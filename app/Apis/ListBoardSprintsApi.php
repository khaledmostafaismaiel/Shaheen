<?php

namespace App\Apis;

use App\Models\Board;
use Illuminate\Support\Facades\Http;

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

        $username = $jira->user_name;
        $password = $jira->password;

        $credentials = base64_encode("$username:$password");

        return Http::withHeaders(
            [
                'Authorization' => "Basic $credentials",
            ]
        )->get(
            $jira->domain.'/rest/agile/1.0/board/'.$this->board->jira_board_id.'/sprint',
            [
                'maxResults' => $maxResults,
                'startAt' => ($page - 1) * $maxResults,
            ]
        );
    }
}
