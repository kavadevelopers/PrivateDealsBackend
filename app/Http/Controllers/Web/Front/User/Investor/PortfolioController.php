<?php

namespace App\Http\Controllers\Web\Front\User\Investor;

use App\Enums\InstrumentTypeEnum;
use App\Http\Controllers\Controller;
use App\Repositories\InvestorRepository;
use Illuminate\View\View;

class PortfolioController extends Controller
{

    private $invRepo;

    function __construct(InvestorRepository $investorRepository)
    {
        $this->invRepo = $investorRepository;
    }

    function index(): View
    {
        setPageTitle('Portfolio');
        $portfolio = $this->invRepo->getPortfolio();
        $data['equity'] = (clone $portfolio)->where('instrument', InstrumentTypeEnum::equity);
        $data['ccps'] = (clone $portfolio)->where('instrument', InstrumentTypeEnum::ccps);
        $data['ccd'] = (clone $portfolio)->where('instrument', InstrumentTypeEnum::ccd);
        return view('front.investor.portfolio', $data);
    }
}
