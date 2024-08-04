<?php

namespace App\Actions;

use App\Apis\ListSprintsIssuesApi;
use App\Models\Board;

class ListSprintIssuesAction
{
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

        return $this->dataAndLinks($this->parentsWithChildren($issues), $sprintStartDate, $sprintEndDate);

    }


    private function parentsWithChildren($issues)
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

//            $parentWithChildren['children'] = array_merge($parentWithChildren['children'], $parent['fields']['subtasks']);

            $parentsWithChildren[] = $parentWithChildren;
        }

        return $parentsWithChildren;
    }

    private function dataAndLinks(array $parentsWithChildren, $sprintStartDate, $sprintEndDate)
    {
        $data = [];
        $links = [];

        foreach ($parentsWithChildren as $parentWithChildren) {

            $parent = $this->addParent($parentWithChildren['parent'], $sprintStartDate, $data, $links);

            $this->addChildren($parent, $parentWithChildren['children'], $sprintStartDate, $data, $links);
        }

        return [
            "data"=> $data,
            "links"=> $links,
        ];
    }

    private function convertEstimateToDays($estimateString) {
        $totalDays = 0;

        preg_match_all('/(\d+)([hdw])/i', $estimateString, $matches);
        if($estimateString === "Not Specified"){
           return 1;
        }

        foreach ($matches[0] as $match) {
            list($quantity, $unit) = sscanf($match, '%d%s');

            switch ($unit) {
                case 'h':
                    $totalDays += $quantity / 8;
                    break;
                case 'd':
                    $totalDays += $quantity;
                    break;
                case 'w':
                    $totalDays += $quantity * 5;
                    break;
                default:
                    ;
            }
        }

        return $totalDays;
    }

    private function addParent($parent, $sprintStartDate, &$data, &$links)
    {
        $fields = $parent['fields'];
        $timeTracking = $fields['timetracking']??[];
        $assignee = $fields['assignee']??[];
        $originalEstimates = $timeTracking['originalEstimate']??"Not Specified";
        $remainingEstimate = $timeTracking['remainingEstimate']??"Not Specified";

        $data[] = $this->addTask($parent, $sprintStartDate, $originalEstimates, $remainingEstimate, $assignee, $fields);

//        $this->addLinks($fields['issuelinks']?? [], $parent, $links);

        return $parent;
    }

    private function addChildren($parent, $children, $sprintStartDate, &$data, &$links)
    {
        foreach ($children as $child) {
            $fields = $child['fields'];
            $timeTracking = $fields['timetracking']??[];
            $assignee = $fields['assignee']??[];
            $originalEstimates = $timeTracking['originalEstimate']??"Not Specified";
            $remainingEstimate = $timeTracking['remainingEstimate']??"Not Specified";

            $data[] = $this->addTask($child, $sprintStartDate, $originalEstimates, $remainingEstimate, $assignee, $fields, $parent);

            $this->addLinks($fields['issuelinks']?? [], $child, $links);
        }
    }

    private function addLinks($issueLinks, $target, &$links)
    {
        foreach ($issueLinks as $issueLink) {
            $links[] = [
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
        return [
            "id" => $task['id'],
            "name" => $task['key'],
            "start_date" => $sprintStartDate,
            "original_estimates" => $originalEstimates,
            "remaining_estimates" => $remainingEstimate,
            "assignee" => $assignee['displayName']??"Not Assigned",
            "text" => $fields['summary'],
//            "text" => $task['key'],
            "duration" => ceil($this->convertEstimateToDays($remainingEstimate)),
            "parent"=> $parent['id']??null,
        ];
    }
}
