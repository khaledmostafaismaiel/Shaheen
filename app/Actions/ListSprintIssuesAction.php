<?php

namespace App\Actions;

use App\Apis\ListSprintsIssuesApi;
use App\Helpers\Helpers;
use App\Models\Board;
use App\Models\Issue;

class ListSprintIssuesAction
{
    private array $data;
    private array $links;

    public function __construct()
    {
        $this->data = [];
        $this->links = [];
    }

    public function execute(Board $board, $sprintId, $sprintStartDate, $sprintEndDate)
    {
        $page = 1;
        $issues = [];

        $listSprintsIssuesApi = new ListSprintsIssuesApi($board, $sprintId);
        do{
            $response = $listSprintsIssuesApi->call($page);

            if ($response->successful()) {
                $issues = array_merge($issues, $response->json()['issues']);
            }

            $page += 1;
        }while($response->successful() && $response->json()['total'] > count($issues));

        return $this->dataAndLinks($this->parentsWithChildren($issues, $board), $sprintStartDate, $sprintEndDate);

    }


    private function parentsWithChildren(array $issues, Board $board)
    {
        $parents = [];
        $children = [];
        foreach ($issues as $issue) {
            if( ! isset($issue['fields']['parent'])){
                $parents[] = $issue;
            }else{
                $children[] = $issue;
            }
        }


        $parentsWithChildren = [];

        foreach ($parents as $parent) {
            $parentWithChildren = [
                "parent"=>$parent,
                "children"=>[],
            ];

            foreach ($children as $child) {
                if($child['fields']['parent']['id'] === $parent['id']){
                    $parentWithChildren['children'][] = $child;
                }
            }

            $parentWithChildren['children'] = array_merge($parentWithChildren['children'], $parent['fields']['subtasks']);

            $parentsWithChildren[] = $parentWithChildren;

            $this->syncIssues($parentWithChildren, $board);
        }

        return $parentsWithChildren;
    }

    private function dataAndLinks(array $parentsWithChildren, $sprintStartDate, $sprintEndDate)
    {
        foreach ($parentsWithChildren as $parentWithChildren) {

            $parent = $this->addParent($parentWithChildren['parent'], $sprintStartDate);

            $this->addChildren($parent, $parentWithChildren['children'], $sprintStartDate);

        }

        $this->overrideParentStartAndEndDates();

        return [
            "data"=> $this->data,
            "links"=> $this->links,
        ];
    }

    private function addParent($parent, $sprintStartDate)
    {
        $fields = $parent['fields'];
        $timeTracking = $fields['timetracking']??[];
        $assignee = $fields['assignee']??[];
        $originalEstimates = $timeTracking['originalEstimate']??"Not Specified";
        $remainingEstimate = $timeTracking['remainingEstimate']??"Not Specified";

        $task = $this->addTask($parent, $sprintStartDate, $originalEstimates, $remainingEstimate, $assignee, $fields);
        $this->data[] = $task;

        $this->addLinks($fields['issuelinks']?? [], $parent);

        return $parent;
    }

    private function addChildren($parent, $children, $sprintStartDate)
    {
        foreach ($children as $child) {
            $fields = $child['fields'];
            $timeTracking = $fields['timetracking']??[];
            $assignee = $fields['assignee']??[];
            $originalEstimates = $timeTracking['originalEstimate']??"Not Specified";
            $remainingEstimate = $timeTracking['remainingEstimate']??"Not Specified";

            $task = $this->addTask($child, $sprintStartDate, $originalEstimates, $remainingEstimate, $assignee, $fields, $parent);
            $this->data[] = $task;

            $this->addLinks($fields['issuelinks']?? [], $child);
        }
    }

    private function addLinks($issueLinks, $target)
    {
        foreach ($issueLinks as $issueLink) {
            $this->links[] = [
                "id"=> $issueLink['id'],
                "source"=> $issueLink['inwardIssue']['id']??$issueLink['outwardIssue']['id'],
                "target"=> $target['id'],
                "type"=> 0,
            ];
        }
    }

    private function addTask(
        array $task,
        string $sprintStartDate,
        string $originalEstimates,
        string $remainingEstimate,
        array $assignee,
        array $fields,
        array $parent=[]
    )
    {
        $data = [
            "id" => $task['id'],
            "name" => $task['key'],
            "original_estimates" => $originalEstimates,
            "remaining_estimates" => $remainingEstimate,
            "assignee" => $assignee['displayName']??"Not Assigned",
            "text" => $fields['summary'],
            "parent"=> $parent['id']??null,
        ];

        return array_merge($data, $this->addStartDateAndEndDate($task['id'], $remainingEstimate, $sprintStartDate));
    }

    private function syncIssues(array $parentWithChildren, Board $board)
    {
        $this->addIssue($parentWithChildren['parent'], $board);

        foreach ($parentWithChildren['children'] as $child){
            $this->addIssue($child, $board);
        }

        $this->deleteIssues($parentWithChildren);
    }

    private function addIssue($issue, Board $board)
    {
        $parent = $issue['fields']['parent']??[];
        return Issue::updateOrCreate(
            [
                'board_id'=>$board->id,
                'jira_issue_id'=>$issue['id'],
                'jira_parent_id'=>$parent['id']??null,
            ]
        );
    }

    private function deleteIssues(array $parentWithChildren)
    {
        Issue::where('jira_parent_id', $parentWithChildren['parent']['id'])
            ->whereNotIn('jira_issue_id', collect($parentWithChildren['children'])->pluck('id')->toArray())
            ->delete();
    }

    private function addStartDateAndEndDate(string $taskId, string $remainingEstimate, string $sprintStartDate)
    {
        $issue = Issue::findByJiraIssueId($taskId);
        if($issue->start_date && $issue->end_date){
            return [
                "start_date"=>$issue->start_date,
                "end_date"=>$issue->end_date,
            ];
        }else{
            $duration = (int)ceil(Helpers::convertEstimateToDays($remainingEstimate));
            $endDate = date("Y-m-d", strtotime($sprintStartDate."+".($duration)." days"));
            do{
                $weekends = Helpers::countWeekends($sprintStartDate, date("Y-m-d", strtotime($endDate." -1 days")));
                $endDate = date("Y-m-d", strtotime($sprintStartDate."+".($duration + $weekends)." days"));

                $newEndDateWeekends =  Helpers::countWeekends($sprintStartDate, date("Y-m-d", strtotime($endDate." -1 days")));
            }while($newEndDateWeekends > $weekends);

            return [
                "start_date"=>$sprintStartDate,
                "end_date" => $endDate,
            ];
        }
    }

    private function overrideParentStartAndEndDates()
    {
        foreach ($this->data as $key=>$task){
            $children = array_filter($this->data, function ($issue) use ($task) {
                return $issue['parent'] == $task['id'];
            });

            if(count($children)){
                $startDates = array_map(function($task) {
                    return $task['start_date'];
                }, $children);

                $this->data[$key]['start_date'] = min($startDates);

                $endDates = array_map(function($task) {
                    return $task['end_date'];
                }, $children);

                $this->data[$key]['end_date'] = max($endDates);
            }
        }
    }
}
