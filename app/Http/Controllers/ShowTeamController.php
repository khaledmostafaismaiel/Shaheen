<?php

namespace App\Http\Controllers;

use App\Actions\ListBoardsAction;
use App\Models\Team;

class ShowTeamController extends Controller
{
    public function __invoke(Team $team)
    {
        $jira = $team->jira;

        $boards = (new ListBoardsAction)
            ->execute($team);

        return view('show-team', compact(['jira', 'team', 'boards']));
    }
}
