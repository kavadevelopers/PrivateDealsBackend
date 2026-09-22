<?php

namespace App\Http\Controllers\Web\Front\User\Investor;

use App\Http\Controllers\Controller;
use App\Models\InvestorMandatesModel;
use App\Repositories\InvestorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BankMandateController extends Controller
{

   private $invRepo;

   function __construct(InvestorRepository $investorRepository)
   {
      $this->invRepo = $investorRepository;
   }

   function mandateList(): View
   {
      setPageTitle('Bank Mandates');
      $data['mandates'] = $this->invRepo->getBankMandates();
      return view('front.investor.bankmandate', $data);
   }
}
