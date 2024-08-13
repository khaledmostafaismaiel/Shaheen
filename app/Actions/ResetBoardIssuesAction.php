<?php

namespace App\Actions;

use App\Models\Board;

class ResetBoardIssuesAction
{
    public function execute(Board $board)
    {
        $board->issues()
            ->delete();
    }
}
