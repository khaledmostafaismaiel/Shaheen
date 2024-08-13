<?php

namespace App\Http\Controllers;

use App\Actions\DeleteIssueLinkAction;
use App\Models\Jira;

class DeleteGanttTaskLinkController extends Controller
{
    public function __invoke(Jira $jira, $linkId)
    {
        (new DeleteIssueLinkAction)
            ->execute($jira, $linkId);

        return response()->json(
            [
                "action"=> "deleted"
            ]
        );
    }
}
