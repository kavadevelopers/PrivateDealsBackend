<?php

namespace App\Http\Controllers\Web\Admin\Partner;

use App\Enums\PartnerTypeEnum;
use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Models\InvestorModel;
use App\Models\PartnerModel;
use App\Repositories\PartnerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RetailersController extends Controller
{
    private $partnerRepo;

    function __construct(PartnerRepository $partnerRepo)
    {
        $this->partnerRepo = $partnerRepo;
    }
    function create(): View
    {
        setPageTitle('Create Retailers');
        // $partners = PartnerModel::whereIn('parent_type', [PartnerTypeEnum::wealthmanager->value, PartnerTypeEnum::distributor->value])->get();
        $partners = PartnerModel::where('type', PartnerTypeEnum::wealthmanager)
            ->orWhere('type', PartnerTypeEnum::distributor)->where('is_deleted', '0')
            ->get();
        return view('admin.pages.partner.retailers.create', compact('partners'));
    }

    function list(Request $request): View
    {
        setPageTitle('Retailers');
        $data['list'] = PartnerModel::where('is_deleted', '0')->where('type', PartnerTypeEnum::retailer->value)->where('is_demo', '0')->get();
        addVendor('datatables');
        return view('admin.pages.partner.retailers.list')->with($data);
    }

    function view(string $uuid): View|RedirectResponse
    {
        $partner = PartnerModel::where('is_deleted', '0')->where('uuid', $uuid)->first();
        if ($partner) {
            setPageTitle(ucfirst($partner->name) . "'s Profile");
            $data['partner'] = $partner;
            $allPartner = PartnerModel::where('parent_id', $partner->id)->where('is_deleted', '0')->where('type', PartnerTypeEnum::relationmanager->value)->get();
            $data['allPartner'] = $allPartner;
            return view('admin.pages.partner.view', $data);
        }

        return redirect()->back()->with('error', 'Partner not found');
    }

    function edit(string $uuid): View|RedirectResponse
    {
        $item = PartnerModel::where('is_deleted', '0')->where('uuid', $uuid)->first();
        if ($item) {
            setPageTitle('Edit Retailer');
            $data['wealthmanagerlist'] = PartnerModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            $data['item'] = $item;
            $data['partners'] = PartnerModel::where('type', PartnerTypeEnum::wealthmanager)
                ->orWhere('type', PartnerTypeEnum::distributor)->where('is_deleted', '0')
                ->get();
            return view('admin.pages.partner.retailers.edit')->with($data);
        }

        return redirect()->route('admin.partner.retailers.list')->with('error', 'Item not found');
    }

    function store(): RedirectResponse
    {
        return $this->partnerRepo->newDistributorSave();
    }

    function update(): RedirectResponse
    {
        return $this->partnerRepo->newDistributorSave();
    }

    function delete(string $id): RedirectResponse
    {
        $item = PartnerModel::where('is_deleted', '0')->find($id);

        if ($item) {
            // $this->deleteFile($item->profile_photo);
            $item->is_deleted = '1';
            $item->update();
            $item->tokens()->delete();
            AdminHelper::logPut('Deleted Retailer', PartnerModel::class, $item->id);
            return redirect()->route('admin.partner.retailers.list')
                ->with('success', 'Retailer deleted.');
        }

        return redirect()->route('admin.partner.retailers.list')->with('error', 'Item not found');
    }
}
