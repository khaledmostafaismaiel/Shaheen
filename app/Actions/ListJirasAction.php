<?php

namespace App\Actions;

use App\Models\Jira;

class ListJirasAction
{
    public function execute(int $perPage = 10)
    {
        return Jira::with('teams')
            ->paginate($perPage);
    }
}
