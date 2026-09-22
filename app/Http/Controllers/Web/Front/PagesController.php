<?php

namespace App\Http\Controllers\Web\Front;

use Illuminate\Support\Facades\Validator;
use App\Helpers\CommonHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\CmsContactModel;
use App\Models\CmsFeedbackModel;
use App\Models\MasterBlogModel;
use App\Models\MasterPagesModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PagesController extends Controller
{
    function feedbackSave(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'name'          => 'required|string|max:250',
            'email'         => 'required|email|max:250',
            'description'   =>  'required'
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $response = Http::asForm()->withOptions([
            'verify' => false, 'Content-Type' => 'application/x-www-form-urlencoded'
        ])->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => CommonHelper::appSettings('google_recaptcha_secret'),
            'response' => $request->recaptcha_token,
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            if ($responseData['success']) {
                CmsFeedbackModel::create([
                    'type'          => $request->type,
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'description'   => $request->description
                ]);
                Session::flash('success', 'Feedback Shared');
                return UtillsHelper::json(1, ['message' => 'Feedback Shared']);
            }
        }
        return UtillsHelper::json(0, ['message' => 'Recaptcha failed']);
    }

    function contactusSave(Request $request): JsonResponse
    {

        $validation = Validator::make($request->all(), [
            'firstname'        => 'required|string|max:250',
            'lastname'         => 'required|string|max:250',
            'email'            =>  'required|email|max:250',
            'mobile_no'        =>  'required|numeric|digits:10',
            'description'      =>  'required'
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $response = Http::asForm()->withOptions([
            'verify' => false, 'Content-Type' => 'application/x-www-form-urlencoded'
        ])->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => CommonHelper::appSettings('google_recaptcha_secret'),
            'response' => $request->recaptcha_token,
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            if ($responseData['success']) {
                CmsContactModel::create([
                    'firstname'         => $request->firstname,
                    'lastname'          => $request->lastname,
                    'mobile_no'         => $request->mobile_no,
                    'email'             => $request->email,
                    'description'       => $request->description
                ]);
                Session::flash('success', 'Contact Shared');
                return UtillsHelper::json(1, ['message' => 'Contact Shared']);
            }
        }
        return UtillsHelper::json(0, ['message' => 'Recaptcha failed']);
    }

    //legal info
    function riskwarings(): View
    {
        setPageTitle('Risk Warings');
        $data['page'] = MasterPagesModel::where('id', '3')->first();
        return view('front.pages.common', $data);
    }

    function privacynotice(): View
    {
        setPageTitle('Privacy Notice');
        $data['page'] = MasterPagesModel::where('id', '4')->first();
        return view('front.pages.common', $data);
    }

    function termsofservice(): View
    {
        setPageTitle('Terms of Service');
        $data['page'] = MasterPagesModel::where('id', '5')->first();
        return view('front.pages.common', $data);
    }

    function howtoinvest(): View
    {
        setPageTitle('How to invest');
        $data['page'] = MasterPagesModel::where('id', '6')->first();
        return view('front.pages.common', $data);
    }

    //about shurua4
    function aboutus(): View
    {
        setPageTitle('About Us');
        $data['page'] = MasterPagesModel::where('id', '1')->first();
        return view('front.pages.common', $data);
    }

    function bloglist(): View
    {
        setPageTitle('Blog');
        $data['blogs'] = MasterBlogModel::where('is_deleted', '0')->orderBy('display_order', 'asc')->get();
        return view('front.pages.blog.list', $data);
    }

    function blogview($slug): View|RedirectResponse
    {
        $blog = MasterBlogModel::where('is_deleted', '0')->where('url_slug', $slug)->first();
        if ($blog) {
            setPageTitle($blog->title);
            $data['item'] = $blog;
            return view('front.pages.blog.view', $data);
        }
        return redirect()->route('front.pages.blog.list');
    }

    function careers(): View
    {
        setPageTitle('Careers');
        $data['page'] = MasterPagesModel::where('id', '2')->first();
        return view('front.pages.common', $data);
    }

    function feedback(): View
    {
        setPageTitle('Feedback');

        return view('front.pages.feedback');
    }

    function contactus(): View
    {
        setPageTitle('Contact Us');
        return view('front.pages.contact');
    }
}
