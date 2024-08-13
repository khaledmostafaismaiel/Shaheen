<?php

namespace App\Actions;

use App\Apis\DeleteLinkIssueApi;
use App\Models\Jira;

class DeleteIssueLinkAction
{
    public function execute(Jira $jira, $linkId)
    {
        $response = (new DeleteLinkIssueApi($jira))
            ->call($linkId);

        $getResponse = $response?->transferStats?->getResponse();
        $statusCode = $getResponse?->getStatusCode();
        $reasonPhrase = $getResponse?->getReasonPhrase();

        return [
            "statusCode"=> $statusCode,
            "message"=> $reasonPhrase,
        ];
    }
}
