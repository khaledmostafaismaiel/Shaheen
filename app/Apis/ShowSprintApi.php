<?php

namespace App\Apis;

use App\Models\Jira;

class ShowSprintApi
{
    private $jira;
    private $sprintId;
    public function __construct(Jira $jira, $sprintId)
    {
        $this->jira = $jira;
        $this->sprintId = $sprintId;
    }

    public function call()
    {
        $jiraApi = new JiraApi($this->jira);

        $url = $this->jira->domain.'/rest/agile/1.0/sprint/'.$this->sprintId;

        return $jiraApi->get($url);
    }
}
