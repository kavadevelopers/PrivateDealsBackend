<?php

namespace App\Http\Controllers\Web\Front\User;

use App\Http\Controllers\Controller;
use App\Models\MasterCityModel;
use App\Repositories\InvestorRepository;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    private $invRepo;

    function __construct(InvestorRepository $investorRepository)
    {
        $this->invRepo = $investorRepository;
    }

    public function investorList()
    {
        $request = request();
        if ($request->routeIs('front.business.*')) {
            setPageTitle('Investors');
        } else {
            setPageTitle('My Family');
        }
        $data['list'] = $this->invRepo->investorList();
        return view('front.common.investor.list', $data);
    }

    public function investorAdd()
    {
        $request = request();
        if ($request->routeIs('front.business.*')) {
            setPageTitle('Add Investor');
        } else {
            setPageTitle('Add Family');
        }
        $data['cities'] = MasterCityModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        return view('front.common.investor.addinvestor', $data);
    }

    public function investorSave()
    {
        return $this->invRepo->investorSave();
    }
}
