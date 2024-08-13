<?php

namespace App\Observers;

use App\Models\Board;

class BoardObserver
{
    public function deleted(Board $board): void
    {
        $board->issues()
            ->delete();
    }
}
