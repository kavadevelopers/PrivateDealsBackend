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
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class DistributorController extends Controller
{
    private $partnerRepo;

    function __construct(PartnerRepository $partnerRepo)
    {
        $this->partnerRepo = $partnerRepo;
    }
    function create(): View
    {
        setPageTitle('Create Distributor');
        $data['wealthmanagerlist'] = PartnerModel::where('is_deleted', '0')->where('type', PartnerTypeEnum::wealthmanager)->orderby('id', 'desc')->get();
        return view('admin.pages.partner.distributor.create')->with($data);
    }

    function list(): View
    {
        setPageTitle('Distributors');
        $data['list'] = PartnerModel::where('is_deleted', '0')->where('is_demo', '0')->where('type', PartnerTypeEnum::distributor)->get();
        addVendor('datatables');
        return view('admin.pages.partner.distributor.list')->with($data);
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
            setPageTitle('Edit Distributor');
            $data['wealthmanagerlist'] = PartnerModel::where('is_deleted', '0')->where('type', PartnerTypeEnum::wealthmanager)->orderby('id', 'desc')->get();
            $data['item'] = $item;
            return view('admin.pages.partner.distributor.edit')->with($data);
        }

        return redirect()->route('admin.partner.distributor.list')->with('error', 'Item not found');
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
            AdminHelper::logPut('Deleted distributor', PartnerModel::class, $item->id);
            return redirect()->route('admin.partner.distributor.list')
                ->with('success', 'Distributor deleted.');
        }

        return redirect()->route('admin.partner.distributor.list')->with('error', 'Item not found');
    }
}
