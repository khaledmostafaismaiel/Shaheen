<?php

namespace App\Apis;

use App\Models\Board;

class ListBoardSprintsApi
{
    private $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    public function call(int $page=1, int $maxResults=100)
    {
        $jira = $this->board->team->jira;

        $jiraApi = new JiraApi($jira);

        $url = $jira->domain.'/rest/agile/1.0/board/'.$this->board->jira_board_id.'/sprint';

        return $jiraApi->get($url, $page, $maxResults);
    }
}
