<?php

namespace App\Actions;

use App\Models\Team;

class ListBoardsAction
{
    public function execute(Team $team, int $perPage = 10)
    {
        return $team->boards()
            ->paginate($perPage);
    }
}
