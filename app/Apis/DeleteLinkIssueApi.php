<?php

namespace App\Apis;

use App\Models\Jira;

class DeleteLinkIssueApi
{
    private $jira;
    public function __construct(Jira $jira)
    {
        $this->jira = $jira;
    }

    public function call(string $linkId)
    {
        $jiraApi = new JiraApi($this->jira);

        $url = $this->jira->domain.'/rest/api/2/issueLink/'.$linkId;

        return $jiraApi->delete($url);
    }
}
