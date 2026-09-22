<?php

namespace App\Http\Controllers\Api\V1\Investor;

use App\Http\Controllers\Controller;
use App\Repositories\InvestorRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommonKycController extends Controller
{
    private $invRepo;

    function __construct(InvestorRepository $investorRepository)
    {
        $this->invRepo = $investorRepository;
    }

    function dematBank(): JsonResponse
    {
        return $this->invRepo->dematBank();
    }

    function aadharPanStore(): JsonResponse
    {
        return $this->invRepo->aadharPanStore();
    }

    function pan(): JsonResponse
    {
        return $this->invRepo->pan();
    }

    function bankAccountDetails(): JsonResponse
    {
        return $this->invRepo->bankAccountDetails();
    }
}
