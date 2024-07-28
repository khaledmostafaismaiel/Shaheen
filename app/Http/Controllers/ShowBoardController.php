<?php

namespace App\Http\Controllers;

use App\Actions\ListBoardSprintsAction;
use App\Models\Board;

class ShowBoardController extends Controller
{
    public function __invoke(Board $board)
    {
        $team = $board->team;

        $response = (new ListBoardSprintsAction)
            ->execute($board);

        $sprints = $response['sprints'];

        $this->setSessionMessage($sprints);

        $this->setResponseMessage($response);

        $jira = $team->jira;

        return view('show-board', compact(['team', 'jira', 'board', 'sprints']));
    }

    private function setResponseMessage(array $response)
    {
        if($response['statusCode'] !== 200){
            session()->flash('status', $response['message']);
        }
    }

    private function setSessionMessage(array $sprints)
    {
        if($sprints === []){
            session()->flash('status', "There are no active sprints for this board.");
        }
    }
}
