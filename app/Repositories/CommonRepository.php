<?php

namespace App\Repositories;

use App\Helpers\UtillsHelper;
use App\Jobs\common\ContactUsNotificationJob;
use App\Models\CmsContactModel;
use App\Models\InvestorModel;
use App\Models\PartnerModel;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CommonRepository
{


    function contactUs(): JsonResponse|RedirectResponse
    {
        $request = request();
        $validation = Validator::make($request->all(), [
            'name'              => 'required|string|max:250',
            'company'           => 'nullable|string|max:250',
            'mobile_number'     => 'required|numeric|digits:10',
            'email'             => 'required|email|max:250',
            'subject'           => 'required|string|max:250',
            'message'           => 'nullable|string',
        ]);
        if ($validation->fails()) {
            if ($request->is('api/*')) {
                return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
            }

            $firstError = $validation->errors()->first();
            $firstField = $validation->errors()->keys()[0];
            return redirect()->back()
                ->withInput()
                ->withErrors($validation)
                ->with('error', $firstError)
                ->with('focus_field', $firstField);
        }

        $contactus = new CmsContactModel();
        $contactus->firstname = $request->name;
        $contactus->company = $request->company;
        $contactus->mobile_no = $request->mobile_number;
        $contactus->email = $request->email;
        $contactus->subject = $request->subject;
        $contactus->description = $request->message;

        if ($request->routeIs('*.investor.*')) {
            $contactus->user_type = InvestorModel::class;
            $contactus->user_id = $request->user()->id;
        } else if ($request->routeIs('*.business.*')) {
            $contactus->user_type = PartnerModel::class;
            $contactus->user_id = $request->user()->id;
        }

        if ($contactus->save()) {
            ContactUsNotificationJob::dispatch($contactus->id);
            if ($request->is('api/*')) {
                return UtillsHelper::json(1, ['message' => 'Contact details saved successfully']);
            }
            return redirect()->back()->with('success', 'Thank you for sharing your contact details. Our team will reach out to you shortly.');
        } else {
            if ($request->is('api/*')) {
                return UtillsHelper::json(0, ['message' => 'Failed to save record']);
            }
            return redirect()->back()->with('error', 'Failed to save record');
        }
    }
}
