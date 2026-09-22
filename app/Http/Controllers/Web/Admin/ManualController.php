<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\InstrumentTypeEnum;
use App\Enums\PrimaryTransactionPaymentMode;
use App\Enums\PrimaryTransactionTypeEnum;
use App\Helpers\AdminHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\CompanyModel;
use App\Models\InvestorModel;
use App\Models\PortfolioModel;
use App\Models\PortfolioPreIpoModel;
use App\Models\PreIpoModel;
use App\Models\PrimaryTransactionModel;
use App\Models\SecondarySellRequestModel;
use App\Models\SecondaryTransactionModel;
use App\Models\SellerMasterModel;
use App\Models\StartupModel;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManualController extends Controller
{
    function create(): View
    {
        setPageTitle('Secondary Market Entry');
        $investors = InvestorModel::where('is_deleted', '0')->orderby('name', 'asc');
        if (AdminHelper::getAdmin()->role != 'admin') {
            $investors->where('created_by', AdminHelper::getAdmin()->id);
        }
        $data['investors'] = $investors->get();
        $data['startups'] = StartupModel::where('is_deleted', '0')->orderby('brand_name', 'asc')->get();
        return view('admin.pages.manual.secondary-market', $data);
    }

    function save(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'investor_id'       => 'required',
            'startup_id'        => 'required',
            'shares'            => 'required|numeric',
            'exit_amount'       => 'required|numeric',
            'instrument'        => 'required',
            'date'              => 'required|date_format:d-m-Y',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()
                ->with('error', 'Please check form errors.')
                ->withErrors($validation);
        }

        $portfolio = PortfolioModel::where('investor_id', $request->investor_id)
            ->where('startup_id', $request->startup_id)
            ->where('instrument', $request->instrument)
            ->first();

        if ($portfolio) {
            if ($portfolio->shares >= $request->shares) {
                $formattedDate = Carbon::createFromFormat('d-m-Y', $request->date)->startOfDay();
                $sellRequest = new SecondarySellRequestModel;
                $sellRequest->instrument = $request->instrument;
                $sellRequest->status = 7;
                $sellRequest->startup_id = $request->startup_id;
                $sellRequest->portfolio_id = $portfolio->id;
                $sellRequest->investor_id = $request->investor_id;
                $sellRequest->shares = $request->shares;
                $sellRequest->price = $request->exit_amount;
                $sellRequest->purchase_price = $portfolio->purchase_price;
                $sellRequest->current_price = $portfolio->current_share_price;
                $sellRequest->last_traded_price = $portfolio->last_traded_price;
                $sellRequest->created_at = $formattedDate;
                $sellRequest->updated_at = $formattedDate;
                $sellRequest->save();

                AdminHelper::logPut('Secondary Market Entry', SecondarySellRequestModel::class, $sellRequest->id);

                return redirect()->back()->with('success', 'Secondary order placed to market.');
            } else {
                return redirect()->back()->withInput()
                    ->with('error', "Insufficient shares for this transaction. The investor has only {$portfolio->shares} shares.")
                    ->withErrors($validation);
            }
        } else {
            return redirect()->back()->withInput()
                ->with('error', "This investor does not have a portfolio for this startup {$request->instrument} instrument.")
                ->withErrors($validation);
        }
    }

    function preIpoCreate(): View
    {
        setPageTitle('Pre-IPO Manual Transaction');
        $investors = InvestorModel::where('is_deleted', '0')->orderby('name', 'asc');
        if (AdminHelper::getAdmin()->role != 'admin') {
            $investors->where('created_by', AdminHelper::getAdmin()->id);
        }
        $data['investors'] = $investors->get();
        $data['companies'] = CompanyModel::where('is_deleted', '0')->orderby('brand_name', 'asc')->get();
        $data['sellers'] = SellerMasterModel::where('is_deleted', '0')->orderby('company_name', 'asc')->get();
        return view('admin.pages.manual.pre-ipo-transaction', $data);
    }

    function preIpoSave(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'investor_id'       => 'required',
            'company_id'        => 'required',
            'seller_id'         => 'required',
            'shares'            => 'required|numeric',
            'share_price'       => 'required|numeric',
            'shuru_price'       => 'required|numeric',
            'distributer_price'       => 'required|numeric',
            'date'              => 'required|date_format:d-m-Y',
            'transaction_type'  => 'required|in:begin,completed',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()
                ->with('error', 'Please check form errors.')
                ->withErrors($validation);
        }

        $formattedDate = Carbon::createFromFormat('d-m-Y', $request->date)->startOfDay();
        $transaction = new PreIpoModel;
        $transaction->status = ($request->transaction_type == 'begin') ? 0 : 5;
        $transaction->investor_id = $request->investor_id;
        $transaction->company_id = $request->company_id;
        $transaction->seller_id = $request->seller_id;
        $transaction->shares = $request->shares;
        $transaction->share_price = $request->share_price;
        $transaction->shuru_price = $request->shuru_price;
        $transaction->distributer_price = $request->distributer_price;
        $transaction->investment_amount = $request->share_price * $request->shares;
        $transaction->is_distributer = $request->is_distributer;
        $transaction->instrument = InstrumentTypeEnum::equity;
        $transaction->payment_mode = PrimaryTransactionPaymentMode::rtgs;
        if (($request->transaction_type != 'begin')) {
            $transaction->created_by = AdminHelper::getAdmin()->id;
            $transaction->updated_by = AdminHelper::getAdmin()->id;
        }
        $transaction->created_at = $formattedDate;
        $transaction->updated_at = $formattedDate;
        $transaction->save();

        if ($request->transaction_type == 'completed') {
            $transaction->portfolio_id = UtillsHelper::preIpoPortfolio($transaction, true);
            $transaction->save();
        }

        AdminHelper::logPut('Pre-IPO Manual Entry', PreIpoModel::class, $transaction->id);

        return redirect()->back()->with('success', 'Pre ipo transaction created');
    }


    function secondaryCreate(): View
    {
        setPageTitle('Secondary Transaction Entry');
        $investors = InvestorModel::where('is_deleted', '0')->orderby('name', 'asc');
        if (AdminHelper::getAdmin()->role != 'admin') {
            $investors->where('created_by', AdminHelper::getAdmin()->id);
        }
        $data['investors'] = $investors->get();
        $data['requests'] = SecondarySellRequestModel::where('status', '7')->get();
        return view('admin.pages.manual.secondary-transaction', $data);
    }

    function secondarySave(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'investor_id'       => 'required',
            'request_id'        => 'required',
            'shares'            => 'required|numeric',
            'date'              => 'required|date_format:d-m-Y',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()
                ->with('error', 'Please check form errors.')
                ->withErrors($validation);
        }

        $sellRequest = SecondarySellRequestModel::where('id', $request->request_id)->first();

        if ($sellRequest && $sellRequest->shares >= $request->shares) {
            $formattedDate = Carbon::createFromFormat('d-m-Y', $request->date)->startOfDay();
            $secTransaction = new SecondaryTransactionModel;
            $secTransaction->status = 8;
            $secTransaction->startup_id = $sellRequest->startup_id;
            $secTransaction->portfolio_id = $sellRequest->portfolio_id;
            $secTransaction->buyer_id = $request->investor_id;
            $secTransaction->seller_id = $sellRequest->investor_id;
            $secTransaction->sell_request_id = $sellRequest->id;
            $secTransaction->instrument = $sellRequest->instrument;
            $secTransaction->shares = $request->input('shares');
            $secTransaction->share_price = $sellRequest->price;
            $secTransaction->investment_amount = $sellRequest->price * $request->input('shares');
            $secTransaction->is_promoter = 0;
            $secTransaction->created_at = $formattedDate;
            $secTransaction->updated_at = $formattedDate;
            $secTransaction->save();

            if ($dPortfolio = PortfolioModel::where('id', $sellRequest->portfolio_id)->first()) {
                $portfolioId = UtillsHelper::globalPortfolioCreation(
                    $dPortfolio->type,
                    $secTransaction->instrument,
                    $secTransaction->buyer_id,
                    $secTransaction->startup_id,
                    $secTransaction->shares,
                    $secTransaction->investment_amount
                );
                $secTransaction->c_portfolio_id = $portfolioId;
                $secTransaction->save();
            }

            UtillsHelper::globalPortfolioSecondary($sellRequest);

            AdminHelper::logPut('Secondary Manual Entry', SecondaryTransactionModel::class, $secTransaction->id);
            return redirect()->back()->with('success', 'Secondary transaction created.');
        } else {
            return redirect()->back()->withInput()
                ->with('error', "This request does not have shares. this request has {$sellRequest->shares} shares.")
                ->withErrors($validation);
        }
    }

    function primaryCreate(): View
    {
        setPageTitle('Primary Transaction Entry');
        $investors = InvestorModel::where('is_deleted', '0')->orderby('name', 'asc');
        if (AdminHelper::getAdmin()->role != 'admin') {
            $investors->where('created_by', AdminHelper::getAdmin()->id);
        }
        $data['investors'] = $investors->get();
        $data['startups'] = StartupModel::where('is_deleted', '0')->orderby('brand_name', 'asc')->get();
        return view('admin.pages.manual.primary-transaction', $data);
    }

    function primarySave(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'investor_id'       => 'required',
            'type'              => 'required',
            'startup_id'        => 'required',
            'round_id'        => 'required',
            'share_price'            => 'required|numeric',
            'investment_amount'       => 'required|numeric',
            'instrument'       => 'required',
            'date'              => 'required|date_format:d-m-Y',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()
                ->with('error', 'Please check form errors.')
                ->withErrors($validation);
        }

        if ($request->share_price <= 0) {
            return redirect()->back()->withInput()
                ->with('error', 'Share price must be greater than 0 ')
                ->withErrors($validation);
        }

        if ($request->investment_amount <= 0) {
            return redirect()->back()->withInput()
                ->with('error', 'Investment Amount must be greater than 0 ')
                ->withErrors($validation);
        }

        $formattedDate = Carbon::createFromFormat('d-m-Y', $request->date)->startOfDay();
        $transaction = new PrimaryTransactionModel;
        if ($transaction->type == PrimaryTransactionTypeEnum::aif->value) {
            $transaction->status = 4;
        } else {
            $transaction->status = 10;
        }
        $transaction->type          = $request->type;
        $transaction->investor_id   = $request->investor_id;
        $transaction->startup_id = $request->startup_id;
        $transaction->round_id = $request->round_id;
        $transaction->instrument = $request->instrument;
        $transaction->shares = $request->investment_amount / $request->share_price;
        $transaction->share_price = $request->share_price;
        $transaction->investment_amount = $request->investment_amount;
        $transaction->payment_status = 1;
        $transaction->is_share_transfered = 1;
        $transaction->payment_mode = PrimaryTransactionPaymentMode::rtgs;
        $transaction->created_at = $formattedDate;
        $transaction->updated_at = $formattedDate;
        $transaction->save();

        if ($transaction->type == PrimaryTransactionTypeEnum::aif->value) {
            $transaction->fees = ($request->investment_amount * 2) / 100;
            $transaction->gst = ($transaction->fees * 18) / 100;
            $transaction->amount_payable = $request->investment_amount + $transaction->fees + $transaction->gst;
        }
        $transaction->save();

        $portfolioId = UtillsHelper::globalPortfolioCreation(
            $transaction->type,
            $transaction->instrument,
            $transaction->investor_id,
            $transaction->startup_id,
            $transaction->shares,
            $transaction->investment_amount,
        );

        $transaction->portfolio_id = $portfolioId;
        $transaction->save();
        AdminHelper::logPut('Primary Transaction Manual Entry', PrimaryTransactionModel::class, $transaction->id);

        return redirect()->back()->with('success', 'Primary Transaction created');
    }
}
