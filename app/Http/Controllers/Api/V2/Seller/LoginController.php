<?php

namespace App\Http\Controllers\Api\V2\Seller;

use App\Http\Controllers\Controller;
use App\Repositories\V2\SellerRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginController extends Controller
{
    private SellerRepository $sellerRepo;

    function __construct(SellerRepository $sellerRepository)
    {
        $this->sellerRepo = $sellerRepository;
    }

    function login(): JsonResponse
    {
        return $this->sellerRepo->login();
    }

    function logout(): JsonResponse
    {
        return $this->sellerRepo->logout();
    }

    function deleteAccount(): JsonResponse
    {
        return $this->sellerRepo->deleteAccount();
    }

    function profile(): JsonResponse
    {
        return $this->sellerRepo->profile();
    }

    function updateProfile(): JsonResponse
    {
        return $this->sellerRepo->updateProfile();
    }

    function forgot(): JsonResponse
    {
        return $this->sellerRepo->forgot();
    }

    function verifyOtp(): JsonResponse
    {
        return $this->sellerRepo->verifyOtp();
    }

    function resendOtp(): JsonResponse
    {
        return $this->sellerRepo->resendOtp();
    }

    function changePassword(): JsonResponse
    {
        return $this->sellerRepo->changePassword();
    }
}
