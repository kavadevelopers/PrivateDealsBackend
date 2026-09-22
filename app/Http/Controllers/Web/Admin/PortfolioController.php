<?php

namespace App\Http\Controllers\Web\Admin;

use App\DataTables\portfolio\PreIPODataTable as PortfolioPreIPODataTable;
use App\DataTables\portfolio\StartupDataTable as PortfolioStartupDataTable;
use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\InvestorModel;
use App\Models\PortfolioImportModel;
use App\Models\PortfolioModel;
use App\Models\StartupModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PortfolioController extends Controller
{

    function view(string $id): View|RedirectResponse
    {
        $portfolio = PortfolioModel::where('id', $id)->first();
        if ($portfolio) {
            $data['portfolio'] = $portfolio;
            return view('admin.pages.portfolio.view')->with($data);
        }

        return redirect()->back()->with('error', 'Portfoli not found');
    }

    function list(PortfolioStartupDataTable $dataTable): View|JsonResponse
    {
        setPageTitle('Startup Porfolio');
        return $dataTable->render('admin.pages.portfolio.startup.list');
    }

    function preIpoList(PortfolioPreIPODataTable $dataTable): View|JsonResponse
    {
        setPageTitle('Pre-Ipo Porfolio');
        return $dataTable->render('admin.pages.portfolio.preipo.list');
    }

    function portfolioUploadRequest(Request $request): View
    {
        setPageTitle('Porfolio Upload Request');
        if ($request->has('investor_key')) {
            $investor = InvestorModel::where('uuid', $request->investor_key)->first();
            if ($investor) {
                $data['list'] = PortfolioImportModel::where('investor_id', $investor->id)->orderby('id', 'desc')->get();
            } else {
                $data['list'] = PortfolioImportModel::orderby('id', 'desc')->get();
            }
        } else {
            $data['list'] = PortfolioImportModel::orderby('id', 'desc')->get();
        }
        return view('admin.pages.portfolio.upload-request')->with($data);
    }
}
