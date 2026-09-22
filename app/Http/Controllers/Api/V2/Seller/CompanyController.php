<?php

namespace App\Http\Controllers\Api\V2\Seller;

use App\Http\Controllers\Controller;
use App\Repositories\V2\SellerCompanyRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class CompanyController extends Controller
{
    private SellerCompanyRepository $companyRepo;

    function __construct(SellerCompanyRepository $companyRepository)
    {
        $this->companyRepo = $companyRepository;
    }

    function create(): JsonResponse
    {
        return $this->companyRepo->create();
    }

    function checkDuplicate(): JsonResponse
    {
        return $this->companyRepo->checkDuplicate();
    }

    function sectors(): JsonResponse
    {
        return $this->companyRepo->sectors();
    }

    function list(): JsonResponse
    {
        return $this->companyRepo->list();
    }

    function listLite(): JsonResponse
    {
        return $this->companyRepo->listLite();
    }

    function detail(): JsonResponse
    {
        return $this->companyRepo->detail();
    }

    function mySubmissions(): JsonResponse
    {
        return $this->companyRepo->mySubmissions();
    }

    function savePromoters(): JsonResponse
    {
        return $this->companyRepo->savePromoters();
    }

    function saveShareholders(): JsonResponse
    {
        return $this->companyRepo->saveShareholders();
    }

    function listDeals(): JsonResponse
    {
        return $this->companyRepo->listDeals();
    }

    function createDeal(): JsonResponse
    {
        return $this->companyRepo->createDeal();
    }

    function updateDeal(): JsonResponse
    {
        return $this->companyRepo->updateDeal();
    }

    function deleteDeal(): JsonResponse
    {
        return $this->companyRepo->deleteDeal();
    }

    function updateSharePrice(): JsonResponse
    {
        return $this->companyRepo->updateSharePrice();
    }
}
