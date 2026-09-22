<?php

namespace App\Http\Controllers\Web\Front\User\Startup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function index(): View
    {
        
        setPageTitle('Dashboard');
        return view('front.startup.dashboard');
    }
}
