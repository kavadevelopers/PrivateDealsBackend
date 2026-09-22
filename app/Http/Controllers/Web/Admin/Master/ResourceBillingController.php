<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\DateTimeHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterProjectsModel;
use App\Models\ResourceBillingHistoryModel;
use App\Models\ResourceBillingModel;
use Illuminate\Support\Facades\DB;
use Google\Service\CloudMachineLearningEngine\Resource\ProjectsModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ResourceBillingController extends Controller
{
    function list(): View
    {
        setPageTitle('Billing Information');
        $data['list'] = ResourceBillingModel::where('is_deleted', 0)->orderby('id', 'desc')->with('projects')->get();
        return view('admin.pages.resourceBilling.list', $data);
    }

    function create(): View
    {
        setPageTitle('Create Resource Billing');
        $data['projectnames'] = MasterProjectsModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        return view('admin.pages.resourceBilling.create')->with($data);
    }

    function store(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'project_name_id'            => 'required',
            'resourece_type'             => 'required',
            'company'                    => 'required|max:255|string',
            'description'                => 'required',
            'purchase_date'              => 'required|date_format:d-m-Y',
            'renewal_date'               => 'required|date_format:d-m-Y',
            'time_period'                => 'required|integer',
            'amount'                     => 'required|numeric',
            'renewal_amount'             => 'required|numeric'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()
                ->with('error', 'Please check form errors.')->withErrors($validation);
        }

        ResourceBillingModel::create([
            'project_id'                    => $request->project_name_id,
            'resource_type'                 => $request->resourece_type,
            'company'                       => $request->company,
            'description'                   => $request->description,
            'purchase_date'                 => DateTimeHelper::formatDateTime($request->purchase_date, 'Y-m-d'),
            'renewal_date'                  => DateTimeHelper::formatDateTime($request->renewal_date, 'Y-m-d'),
            'time_period'                   => $request->time_period,
            'amount'                        => $request->amount,
            'renewal_amount'                => $request->renewal_amount
        ]);

        return redirect()->route('admin.reports.resourceBilling.list')->with('success', 'Resource Created');
    }

    function billingHistory(Request $request): RedirectResponse|JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'resource_billing_id'  => 'required',
            'file'                => ['required', 'mimes:jpg,png', 'max:' . UtillsHelper::maxFileDocumentSizeInKB()],
            'purchase_date'       => 'required|date_format:d-m-Y',
            'expire_date'         => 'required|date_format:d-m-Y',
            'amount'              => 'required|numeric',
            'renewal_amount'      => 'required|numeric',
        ]);

        // if ($validation->fails()) {
        //     return redirect()->back()
        //         ->withInput()
        //         ->with('error', 'Please check form errors.')
        //         ->withErrors($validation);
        // }

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['errors' => $validation->errors()], 422);
        }
        // return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);


        try {
            DB::beginTransaction();
            $bill = new ResourceBillingHistoryModel();
            $bill->resource_billing_id = $request->resource_billing_id;
            if ($request->hasFile('file')) {
                $bill->file = FileUpDownHelper::resource_billing_image_upload($request->file('file'));
            }
            $bill->purchase_date = DateTimeHelper::formatDateTime($request->purchase_date, 'Y-m-d');
            $bill->expire_date = DateTimeHelper::formatDateTime($request->expire_date, 'Y-m-d');
            $bill->amount = $request->amount;
            $bill->renewal_amount = $request->renewal_amount;
            $bill->save();

            $resourceBilling = ResourceBillingModel::find($request->resource_billing_id);
            $resourceBilling->renewal_date = DateTimeHelper::formatDateTime($request->expire_date, 'Y-m-d');
            $resourceBilling->renewal_amount = $request->renewal_amount;
            $resourceBilling->save();

            $list = ResourceBillingModel::where('is_deleted', 0)->orderby('id', 'desc')->with('projects')->get();
            DB::commit();
            return UtillsHelper::json(1, ['message' => 'Resource Created', 'table' => view('admin.pages.resourceBilling.table', ['resourceBilling' => $list])->render()], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return UtillsHelper::json(0, ['message' => 'Failed to create resource. Please try again.']);
        }
    }
}
