<?php

namespace App\Apis;

use App\Models\Jira;

class GetIssueApi
{
    private $jira;
    public function __construct(Jira $jira)
    {
        $this->jira = $jira;
    }

    public function call(string $issueIdOrKey)
    {
        $jiraApi = new JiraApi($this->jira);

        $url = $this->jira->domain.'/rest/agile/1.0/issue/'.$issueIdOrKey;

        return $jiraApi->get($url);
    }
}
