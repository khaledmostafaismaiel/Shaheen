<?php

namespace App\Apis;

use App\Models\Board;

class ListSprintsIssuesApi
{
    private $board;
    private $sprintId;
    public function __construct(Board $board, $sprintId)
    {
        $this->board = $board;
        $this->sprintId = $sprintId;
    }

    public function call(int $page=1, int $maxResults=100)
    {
        $jira = $this->board->team->jira;

        $jiraApi = new JiraApi($jira);

        $url = $jira->domain.'/rest/agile/1.0/board/'.$this->board->jira_board_id.'/sprint/'.$this->sprintId.'/issue';

        return $jiraApi->get($url, $page, $maxResults);
    }
}
