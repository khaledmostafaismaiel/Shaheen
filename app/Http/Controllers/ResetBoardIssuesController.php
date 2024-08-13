<?php

namespace App\Http\Controllers;

use App\Actions\ResetBoardIssuesAction;
use App\Models\Board;

class ResetBoardIssuesController extends Controller
{
    public function __invoke(Board $board)
    {
        (new ResetBoardIssuesAction)
            ->execute($board);

        $this->setSessionMessage();

        return redirect()->back();
    }

    private function setSessionMessage()
    {
        session()->flash('status', "Board issues have been reset.");
    }
}
