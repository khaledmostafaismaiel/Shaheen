<?php

namespace App\Http\Controllers;

use App\Actions\ShowSprintAction;
use App\Models\Board;
class ShowSprintController extends Controller
{
    public function __invoke(Board $board, $sprintId)
    {
        $team = $board->team;

        $jira = $team->jira;

        $response = (new ShowSprintAction)
            ->execute($jira, $sprintId);

        $this->setSessionMessage($response);

        $sprint = $response['sprint'];

        $readOnly =  ! auth()->id();

        return view('show-sprint', compact(['jira', 'team', 'board', 'sprint', 'readOnly']));
    }

    private function setSessionMessage(array $response)
    {
        if($response['statusCode'] !== 200){
            session()->flash('status', $response['message']);
        }
    }
}
