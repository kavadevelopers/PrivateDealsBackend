<?php

namespace App\Http\Controllers\Web\Front\User\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    function index(): View
    {
        setPageTitle('Dashboard');
        return view('front.partner.dashboard');
    }
}
