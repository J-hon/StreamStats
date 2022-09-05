<?php

namespace App\Http\Controllers\Api;

use Illuminate\View\View;

class DashboardController
{

    public function index(): View
    {
        return view('dashboard');
    }

}
