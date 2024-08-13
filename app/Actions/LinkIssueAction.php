<?php

namespace App\Actions;

use App\Apis\LinkIssueApi;
use App\Models\Jira;

class LinkIssueAction
{
    private $jira;
    public function __construct(Jira $jira)
    {
        $this->jira = $jira;
    }

    public function execute($sourceId, $targetId)
    {
        $linkIssueApi = new LinkIssueApi($this->jira);

        return $linkIssueApi->call($sourceId, $targetId);
    }
}
