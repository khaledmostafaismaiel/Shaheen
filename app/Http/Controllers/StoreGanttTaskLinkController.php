<?php

namespace App\Http\Controllers;

use App\Actions\GetLinkIdAction;
use App\Actions\LinkIssueAction;
use App\Models\Jira;
use Illuminate\Http\Request;

class StoreGanttTaskLinkController extends Controller
{
    public function __invoke(Jira $jira, Request $request)
    {
        $linkIssueAction = new LinkIssueAction($jira);

        $linkIssueAction->execute($request->source, $request->target);

        $getLinkIdAction = new GetLinkIdAction($jira);

        $id = $getLinkIdAction->execute($request->source, $request->target);

        return response()->json(
            [
                "action"=> "inserted",
                "tid" => $id,
            ]
        );
    }

}
