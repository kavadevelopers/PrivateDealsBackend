<?php

namespace App\Http\Controllers\Web\Front\User\Investor;

use App\Http\Controllers\Controller;
use App\Models\PortfolioModel;
use App\Repositories\InvestorRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MISController extends Controller
{

    private $invRepo;

    function __construct(InvestorRepository $investorRepository)
    {
        $this->invRepo = $investorRepository;
    }

    function index(): View
    {
        setPageTitle('MIS');
        $data['startups'] = $this->invRepo->getMIS();
        return view('front.investor.mis', $data);
    }
}
