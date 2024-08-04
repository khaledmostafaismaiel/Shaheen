<?php

namespace App\Http\Controllers;

use App\Actions\ListSprintIssuesAction;
use App\Models\Board;
use Illuminate\Http\Request;

class ListSprintIssuesController extends Controller
{
    public function __invoke(Request $request, Board $board, $sprintId)
    {
        $result = (new ListSprintIssuesAction)
            ->execute($board, $sprintId, $request->sprintStartDate, $request->sprintEndDate);

        return response()
            ->json($result);
    }
}
