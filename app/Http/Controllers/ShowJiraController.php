<?php

namespace App\Http\Controllers;

use App\Actions\ListTeamsAction;
use App\Models\Jira;

class ShowJiraController extends Controller
{
    public function __invoke(Jira $jira)
    {
        $teams = (new ListTeamsAction)
            ->execute($jira);

        return view('show-jira', compact(['jira', 'teams']));
    }
}
