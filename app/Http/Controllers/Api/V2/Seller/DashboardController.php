<?php

namespace App\Http\Controllers\Api\V2\Seller;

use App\Http\Controllers\Controller;
use App\Repositories\V2\SellerDashboardRepository;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __construct(private SellerDashboardRepository $dashboardRepo)
    {
    }

    public function index(): JsonResponse
    {
        return $this->dashboardRepo->dashboard();
    }
}
