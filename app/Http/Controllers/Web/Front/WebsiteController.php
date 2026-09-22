<?php

namespace App\Http\Controllers\Web\Front;

use App\Enums\NotificationTypeEnum;
use App\Enums\PreIpoCategoryEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\BetaTestingModel;
use App\Models\CmsFaqsModel;
use App\Models\CompanyModel;
use App\Models\CompanyShareHolderPercentageModel;
use App\Models\MasterBlogModel;
use App\Models\RequestAccessParameterModel;
use App\Models\WebsiteMediaModel;
use App\Models\InvestorRegisterRequestModel;
use App\Repositories\CommonRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repositories\InvestorRepository;
use App\Helpers\SeoMetaHelper;
use App\Helpers\SeoHelper;

class WebsiteController extends Controller
{
    private $commonRepo;

    private $invRepo;

    function __construct(InvestorRepository $investorRepository, CommonRepository $commonRepository)
    {
        $this->commonRepo = $commonRepository;
        $this->invRepo = $investorRepository;
    }


    function index(Request $request): View
    {
        setPageTitle('Home');
        $userAgent = strtolower($request->header('User-Agent'));
        $deviceType = 'web';

        if (strpos($userAgent, 'android') !== false) {
            $deviceType = 'android';
        } elseif (preg_match('/iphone|ipad|ipod/', $userAgent)) {
            $deviceType = 'ios';
        } elseif (strpos($userAgent, 'macintosh') !== false) {
            $deviceType = 'macos';
        } elseif (strpos($userAgent, 'windows') !== false) {
            $deviceType = 'desktop';
        }

        // Store data in the database if parameters exist
        if ($request->has(['name', 'email', 'mobile'])) {
            RequestAccessParameterModel::create([
                'name'       => $request->query('name'),
                'email'      => $request->query('email'),
                'mobile'     => $request->query('mobile'),
                'firm_name'  => $request->query('firm_name'),
                'device_type' => $deviceType,
                'ip_address' => $request->ip(),
            ]);
        }

        $mediaItems = WebsiteMediaModel::where('is_deleted', '0')->get();
        // if (str_contains(request()->getHost(), 'shuruup.com')) {

        //     return view('welcome', compact('mediaItems'));
        // } else {
        // }
        return view('front.website.home', compact('mediaItems'));
    }

    function aboutus(): View
    {
        setPageTitle('About Us');
        $faqs = CmsFaqsModel::where('is_deleted', 0)
            ->orderBy('display_order', 'asc')
            ->get();
        return view('front.website.about-us', compact('faqs'));
    }

    function contactus(): View
    {
        setPageTitle('Contact Us');
        return view('front.website.contact-us');
    }
    function contactusSave(Request $request): RedirectResponse
    {

        return $this->commonRepo->contactUs();


        // $validation = Validator::make($request->all(), [
        //     'name'              => 'required|string|max:250',
        //     'company'           => 'required|string|max:250',
        //     'mobile_number'     => 'required|numeric|digits:10',
        //     'email'             => 'required|email|max:250',
        //     'subject'           => 'required|string|max:250',
        //     'message'           => 'required|string|max:250',
        // ]);

        // if ($validation->fails()) {
        //     $firstError = $validation->errors()->first();
        //     $firstField = $validation->errors()->keys()[0];

        //     return redirect()->back()
        //         ->withInput()
        //         ->withErrors($validation)
        //         ->with('error', $firstError)
        //         ->with('focus_field', $firstField);
        // }


        // $contactus = new CmsContactModel();
        // $contactus->firstname = $request->name;
        // $contactus->company = $request->company;
        // $contactus->mobile_no = $request->mobile_number;
        // $contactus->email = $request->email;
        // $contactus->subject = $request->subject;
        // $contactus->description = $request->message;
        // UtillsHelper::sendWpMessage(NotificationTypeEnum::event, 'contact_email', WpMessageTypeEnum::text, '6354901928', 'Swati', NULL, [], [$request->name]);
        // if ($contactus->save()) {
        //     return redirect()->back()->with('success', 'Contact details saved successfully');
        // } else {
        //     return redirect()->back()->with('error', 'Failed to save record');
        // }
    }

    function contactusdetails(): View
    {
        setPageTitle('Contact Us');
        return view('front.website.contactus.details');
    }
    function startup(): View
    {
        setPageTitle('Startup');

        // Get blogs for the news slider
        $blogs = MasterBlogModel::where('is_deleted', '0')->orderby('id', 'desc')->get();

        $blogcolumn = ['id', 'type', 'banner', 'title', 'url_slug', 'short_description', 'created_at'];
        $thirdparty = ['id', 'type', 'banner', 'title', 'url_slug', 'short_description', 'long_description', 'created_at'];

        $bloglist = $blogs->map(function ($blog) use ($blogcolumn, $thirdparty) {
            $blogData = null;
            if ($blog->type == 1) {
                $blogData = $blog->only($blogcolumn);
            } elseif ($blog->type == 2) {
                $blogData = $blog->only($thirdparty);
            } else {
                $blogData = $blog;
            }

            // Add computed properties for slider display
            if ($blogData) {
                $blogData['banner_url'] = FileUpDownHelper::get_page_blog_banner_url($blogData['banner']);
                $blogData['category'] = $blogData['type'] == 1 ? 'Blog' : 'News';
                $blogData['description'] = $blogData['short_description'];
            }

            return $blogData;
        })->filter(); // Remove null values

        $pageData = SeoMetaHelper::getPageMetaData('startup');
        return view('front.website.cards.startup', array_merge(compact('bloglist'), $pageData));
    }

    function primary(): View
    {
        setPageTitle('Primary Market');
        $pageData = SeoMetaHelper::getPageMetaData('primary');
        return view('front.website.cards.primary', $pageData);
    }
    function secondary(): View
    {
        setPageTitle('Secondary Market');
        $pageData = SeoMetaHelper::getPageMetaData('secondary');
        return view('front.website.cards.secondary', $pageData);
    }
    function preipo(): View
    {
        setPageTitle('Pre-IPO Investments');
        $listedCompanies = CompanyModel::with(['sector.MasterIndustry'])
            ->where('is_deleted', 0)
            ->where('category', PreIpoCategoryEnum::liquid_stocks->value)
            ->get();

        $exclusiveDealsCompanies = CompanyModel::with(['sector.MasterIndustry'])
            ->where('is_deleted', 0)
            ->where('category', PreIpoCategoryEnum::exclusive_deals->value)
            ->get();

        $pageData = SeoMetaHelper::getPageMetaData('preipo');
        return view('front.website.cards.pre-ipo', array_merge(compact('listedCompanies', 'exclusiveDealsCompanies'), $pageData));
    }

    public function detail($slugOrUuid): View|RedirectResponse
    {
        // Try to find by slug first, then by UUID
        $company = CompanyModel::with(['sector.MasterIndustry', 'customData'])
            ->where('is_deleted', 0)
            ->where(function ($query) use ($slugOrUuid) {
                $query->where('slug', $slugOrUuid)
                    ->orWhere('uuid', $slugOrUuid);
            })
            ->first();

        if (!$company) {
            return redirect()->route('front.cards.preipo')->with('error', 'Company not found');
        }

        // Redirect to slug if accessed via UUID
        if ($company->slug && $slugOrUuid !== $company->slug) {
            return redirect()->route('front.company.detail', $company->slug, 301);
        }

        setPageTitle($company->brand_name . ' - Company Details');

        // Get SEO meta data
        $metaData = SeoMetaHelper::getEntityMetaData($company);

        // Get shareholders data
        $shareholdersData = CompanyShareHolderPercentageModel::with('shareHolder:name,id')
            ->where('company_id', $company->id)
            ->select('share_holder_id', 'year', 'percentage')
            ->orderBy('year', 'asc')
            ->get()
            ->groupBy('year')
            ->map(function ($yearGroup) {
                $formattedData = [];
                foreach ($yearGroup as $shareHolderPercentage) {
                    $formattedData[] = [
                        'name' => $shareHolderPercentage->shareHolder->name,
                        'percentage' => $shareHolderPercentage->percentage
                    ];
                }
                return $formattedData;
            });

        return view('front.website.company.details', array_merge([
            'company' => $company,
            'shareholdersData' => $shareholdersData,
            'canonicalUrl' => route('front.company.detail', $company->slug ?? $company->uuid),
            'schemaMarkup' => SeoHelper::generateInvestmentOpportunitySchema($company),
        ], $metaData));
    }
    function terminal(): View
    {
        setPageTitle('Terminal');
        return view('front.website.terminal-details');
    }

    function disclaimer(): View
    {
        setPageTitle('Disclaimer');
        return view('front.website.legalinsights.disclaimer');
    }
    function privacyPolicy(): View
    {
        setPageTitle('Privacy Policy');
        return view('front.website.legalinsights.privacypolicy');
    }
    function termsOfUse(): View
    {
        setPageTitle('Terms Of Use');
        return view('front.website.legalinsights.termsofuse');
    }

    function riskdisclouser(): View
    {
        setPageTitle('Risk Disclosure');
        return view('front.website.legalinsights.risk_disclouser');
    }

    function team(): View
    {
        setPageTitle('Team');
        abort(404);
        return view('front.website.team');
    }

    public function download(Request $request): RedirectResponse
    {
        $userAgent = $request->userAgent();

        if (stripos($userAgent, 'android') !== false) {
            return redirect('https://play.google.com/store/apps/details?id=com.shuruup.investor');
        } elseif (preg_match('/iPad|iPhone|iPod/', $userAgent)) {
            return redirect('https://apps.apple.com/us/app/shuru-up/id6736905561');
        } else {
            return redirect()->route('front.home');
        }
    }

    public function cmlSteps(): View
    {
        setPageTitle('CML Steps');
        return view('front.website.legalinsights.cml_steps');
    }


    function verifyInquiryVerificationCode(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'name'           => 'required|max:250',
            'mobile_number'  => 'required|numeric|digits:10',
            'email'          => 'required|email|max:250',
            'otp'              => 'required|numeric|digits:6',
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $sessionOtp = session('inquiry_otp');

        if ($request->otp != $sessionOtp) {
            return UtillsHelper::json(0, ['message' => 'Verification code do not match']);
        }

        $investor = InvestorRegisterRequestModel::where('mobile_number', $request->mobile_number)
            ->first();

        if ($investor) {
            return UtillsHelper::json(0, ['message' => 'Mobile number already registered.']);
        }

        $invReg = new InvestorRegisterRequestModel();
        $invReg->name = $request->name;
        $invReg->mobile_number = $request->mobile_number;
        $invReg->email = $request->email;
        $invReg->device = 'web';
        UtillsHelper::sendWpMessage(NotificationTypeEnum::event, 'request_access_email', WpMessageTypeEnum::text, '6354901928', 'Swati', NULL, [], [$request->name]);
        if ($invReg->save()) {
            session()->forget('inquiry_otp');
            return UtillsHelper::json(1, ['message' => 'Inquiry Sent. Thankyou']);
        } else {
            return UtillsHelper::json(0, ['message' => 'Failed to save record']);
        }
    }

    function sendInquiryVerificationCode(Request $request): JsonResponse
    {
        return $this->invRepo->registerInquiry();
        // $validation = Validator::make($request->all(), [
        //     'name'           => 'required|max:250',
        //     'mobile_number'  => 'required|numeric|digits:10',
        //     'email'          => 'required|email|max:250'
        // ]);

        // if ($validation->fails()) {
        //     return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        // }

        // // $code = UtillsHelper::sendVerificationCode('', '', $request->mobile_number, CodeVerificationTypeEnum::register);
        // // session(['inquiry_otp' => $code]);
        // $invReg = new InvestorRegisterRequestModel();
        // $invReg->name = $request->name;
        // $invReg->mobile_number = $request->mobile_number;
        // $invReg->email = $request->email;
        // // $invReg->apple_email = $request->apple_email;
        // $invReg->device = 'web';
        // UtillsHelper::sendWpMessage(NotificationTypeEnum::event, 'request_access_email', WpMessageTypeEnum::text, '6354901928', 'Swati', NULL, [], [$request->name]);
        // if ($invReg->save()) {
        //     session()->forget('inquiry_otp');
        //     return UtillsHelper::json(1, ['message' => 'Inquiry Sent. Thankyou']);
        // } else {
        //     return UtillsHelper::json(0, ['message' => 'Failed to save record']);
        // }
        // // return UtillsHelper::json(1, ['message' => 'OTP sent to ' . $request->mobile_number]);
        // return UtillsHelper::json(1, ['message' => 'Request Send']);
    }

    function betaTesting(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'email'          => 'required|email|max:250'
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $betatesting = new BetaTestingModel();
        $betatesting->email = $request->email;
        $betatesting->save();

        UtillsHelper::sendWpMessage(NotificationTypeEnum::event, 'beta_request_access', WpMessageTypeEnum::text, '9898375981', 'Mehul Kava', NULL, [], [$request->email]);
        UtillsHelper::sendWpMessage(NotificationTypeEnum::event, 'beta_request_access', WpMessageTypeEnum::text, '7984718397', 'Mehul Kava', NULL, [], [$request->email]);

        return UtillsHelper::json(1, ['message' => 'Thank you for your early access request! We’ll be sending your access shortly.']);
    }

    public function trackUrl(Request $request)
    {
        // Detect device type
        $userAgent = strtolower($request->header('User-Agent'));
        $deviceType = 'web';

        if (strpos($userAgent, 'android') !== false) {
            $deviceType = 'android';
        } elseif (preg_match('/iphone|ipad|ipod/', $userAgent)) {
            $deviceType = 'ios';
        } elseif (strpos($userAgent, 'macintosh') !== false) {
            $deviceType = 'macos';
        } elseif (strpos($userAgent, 'windows') !== false) {
            $deviceType = 'desktop';
        }

        // Store data in the database
        RequestAccessParameterModel::create([
            'name'       => $request->query('name'),
            'email'      => $request->query('email'),
            'mobile'     => $request->query('mobile'),
            'firm_name'  => $request->query('firm_name'),
            'device_type' => $deviceType,
            'ip_address' => $request->ip(),
        ]);
        return UtillsHelper::json(1, ['message' => 'Thank you for your early access request! We’ll be sending your access shortly.']);
    }
}
