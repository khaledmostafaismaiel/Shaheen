<?php

namespace App\Actions;

use App\Apis\ListBoardSprintsApi;
use App\Models\Board;

class ListBoardSprintsAction
{
    public function execute(Board $board)
    {
        $page = 1;

        $listBoardSprintsApi = new ListBoardSprintsApi($board);

        do{
            $response = $listBoardSprintsApi->call($page);

            $page += 1;
        }while($response->successful() && isset($response->json()["isLast"]) && $response->json()["isLast"] === false);

        if ($response->successful()) {
            $sprints = array_reverse($response->json()['values']);
            $activeSprints = array_filter($sprints, function ($sprint) {
                return isset($sprint['state']) && $sprint['state'] === 'active';
            });
        }else{
            $activeSprints = [];
        }


        $getResponse = $response?->transferStats?->getResponse();
        $statusCode = $getResponse?->getStatusCode();
        $reasonPhrase = $getResponse?->getReasonPhrase();

        return [
            "statusCode"=> $statusCode,
            "message"=> $reasonPhrase,
            "sprints"=>$activeSprints,
        ];
    }
}
