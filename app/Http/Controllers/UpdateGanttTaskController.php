<?php

namespace App\Http\Controllers;

use App\Models\Jira;
use App\Models\Issue;
use Illuminate\Http\Request;

class UpdateGanttTaskController extends Controller
{
    public function __invoke(Jira $jira, $taskId, Request $request)
    {
        Issue::findByJiraIssueId($taskId)
            ->update(
                [
                   "start_date"=>$request->start_date,
                   "end_date"=>$request->end_date,
                ]
            );


        return response()->json([
            "action"=> "updated"
        ]);
    }
}
