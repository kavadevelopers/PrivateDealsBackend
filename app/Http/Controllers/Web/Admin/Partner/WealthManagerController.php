<?php

namespace App\Http\Controllers\Web\Admin\Partner;

use App\Enums\PartnerTypeEnum;
use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Models\InvestorModel;
use App\Models\PartnerModel;
use App\Repositories\PartnerRepository;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class WealthManagerController extends Controller
{

    use FileUploadTrait;

    private $partnerRepo;

    function __construct(PartnerRepository $partnerRepo)
    {
        $this->partnerRepo = $partnerRepo;
    }

    function create(): View
    {
        setPageTitle('Create Wealth Manager');
        return view('admin.pages.partner.wealthmanger.create');
    }

    function list(): View
    {
        if (request()->routeIs('admin.partner.demo')) {
            setPageTitle('Demo Partners');
            $data['list'] = PartnerModel::where('is_deleted', '0')->where('is_demo', '1')->get();
        } else {
            setPageTitle('Wealth Managers');
            $data['list'] = PartnerModel::where('is_deleted', '0')->where('is_demo', '0')->where('type', PartnerTypeEnum::wealthmanager)->get();
        }
        addVendor('datatables');
        return view('admin.pages.partner.wealthmanger.list')->with($data);
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
            setPageTitle('Edit Wealth Manager');
            $data['item'] = $item;
            return view('admin.pages.partner.wealthmanger.edit')->with($data);
        }

        return redirect()->route('admin.partner.wealthmanager.list')->with('error', 'Item not found');
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
            $item->is_deleted = '1';
            $item->update();
            $item->tokens()->delete();
            AdminHelper::logPut('Deleted Wealth Manager', PartnerModel::class, $item->id);
            $this->deleteFile($item->profile_photo);
            return redirect()->back()
                ->with('success', 'Partner deleted.');
        }

        return redirect()->back()->with('error', 'Item not found');
    }

    function manager(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'partner_id' => 'required',
            'manager_id' => 'required'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation)
                ->with('error', $validation->errors()->first());
        }

        // dd($request->all());

        $partner = PartnerModel::where('id', $request->partner_id)->first();
        if (!$partner) {
            return redirect()->back()->withInput()
                ->with('error', 'Partner not found');
        }

        $partner->created_by = $request->manager_id;
        $partner->save();


        InvestorModel::where('partner_id', $request->partner_id)->update([
            'created_by' => $request->manager_id
        ]);

        return redirect()->back()->with('success', 'Manager Updated');
    }

    function markAsDemo(string $uuid): RedirectResponse
    {
        $partner = PartnerModel::select('id', 'is_demo', 'name')->where('is_deleted', '0')->where('uuid', $uuid)->first();
        if ($partner) {
            $partner->is_demo = $partner->is_demo == '1' ? '0' : '1';
            $partner->save();
            return redirect()->back()->with('success', 'Partner ' . $partner->name . ' Marked as ' . ($partner->is_demo == '1' ? 'Demo' : 'Live'));
        }
        return redirect()->back()->with('error', 'Partner not found');
    }
}
