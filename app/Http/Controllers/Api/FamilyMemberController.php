<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileUpDownHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvestorRequest;
use App\Models\InvestorModel;
use App\Models\MasterCityModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;

class FamilyMemberController extends Controller
{
    function store(InvestorRequest $investorRequest)
    {

        $city = MasterCityModel::where('id', $investorRequest->city_id)->first();

        $investor = new InvestorModel();
        $investor->investor_type = $investorRequest->investor_type;
        $investor->name = $investorRequest->name;
        $investor->mobile_number = $investorRequest->mobile_number;
        $investor->email = $investorRequest->email;
        $investor->address = $investorRequest->address;
        $investor->city_id = $investorRequest->city_id;
        $investor->state_id = $city->state_id;
        $investor->country_id = $city->country_id;
        $investor->pincode = $investorRequest->pincode;
        $investor->gender = $investorRequest->gender;
        $investor->password = Hash::make($investorRequest->password);
        if ($investorRequest->hasFile('profile_photo')) {
            $investor->profile_photo = FileUpDownHelper::investor_profile_photo_upload($investorRequest->file('profile_photo'));
        }
        $investor->registration_step = '3';
        $investor->save();
        return redirect()->route('admin.investor.create')->with('success', 'Investor Created');
    }
}
