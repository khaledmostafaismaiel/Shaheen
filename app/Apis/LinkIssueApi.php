<?php

namespace App\Apis;

use App\Models\Jira;

class LinkIssueApi
{
    private $jira;
    public function __construct(Jira $jira)
    {
        $this->jira = $jira;
    }

    public function call(string $issueKey1, string $issueKey2, string $type='Blocks')
    {
        $jiraApi = new JiraApi($this->jira);

        $url = $this->jira->domain.'/rest/api/2/issueLink';

        $payload = [
            'type' => [
                'name' => $type,
            ],
            'inwardIssue' => [
                'id' => $issueKey1
            ],
            'outwardIssue' => [
                'id' => $issueKey2
            ]
        ];

        return $jiraApi->post($url, $payload);
    }
}
