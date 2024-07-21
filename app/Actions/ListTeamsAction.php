<?php

namespace App\Actions;

use App\Models\Jira;

class ListTeamsAction
{
    public function execute(Jira $jira, int $perPage = 10)
    {
        return $jira->teams()
            ->with('boards')
            ->paginate($perPage);
    }
}
