<?php

namespace App\Actions;

use App\Apis\ShowSprintApi;
use App\Models\Jira;

class ShowSprintAction
{
    public function execute(Jira $jira, $sprintId)
    {
        $response = (new ShowSprintApi($jira, $sprintId))
            ->call();

        if ($response->successful()) {
            $sprint = $response->json();
        }else{
            $sprint = [];
        }

        $getResponse = $response?->transferStats?->getResponse();
        $statusCode = $getResponse?->getStatusCode();
        $reasonPhrase = $getResponse?->getReasonPhrase();

        return [
            "statusCode"=> $statusCode,
            "message"=> $reasonPhrase,
            "sprint"=>$sprint,
        ];
    }
}
