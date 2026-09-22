<?php

namespace App\Http\Controllers\Api\V1\Startup;

use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Repositories\InvestorRepository;
use App\Repositories\StartupRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginController extends Controller
{
    private $startupRepo;

    function __construct(StartupRepository $startupRepository)
    {
        $this->startupRepo = $startupRepository;
    }

    function login(): JsonResponse
    {
        return $this->startupRepo->login();
    }

    function logout(): JsonResponse
    {
        return $this->startupRepo->logout();
    }

    function dashboard(Request $request): JsonResponse
    {
        return UtillsHelper::json(1, ['res' => $request->user()]);
    }
}
