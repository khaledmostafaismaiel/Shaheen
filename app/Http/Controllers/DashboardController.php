<?php

namespace App\Http\Controllers;

use App\Actions\ListJirasAction;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $jiras = (new ListJirasAction)
            ->execute();

        return view('dashboard', compact('jiras'));
    }
}
