<?php

namespace App\Actions;

use App\Apis\GetIssueApi;
use App\Models\Jira;

class GetLinkIdAction
{
    private $jira;
    public function __construct(Jira $jira)
    {
        $this->jira = $jira;
    }

    public function execute($sourceId, $targetId)
    {
        $response = (new GetIssueApi($this->jira))
            ->call($sourceId);

        $id = null;
        foreach ($response->json()['fields']['issuelinks'] as $issuelink) {

            $targetIssue = $issuelink['outwardIssue']?? $issuelink['inwardIssue'];
            if($targetIssue['id'] == $targetId) {
                $id = $issuelink['id'];
                break;
            }
        }
        return $id;
    }
}
