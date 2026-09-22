<?php

use App\Enums\StartupPrimaryRoundStatusEnum;
use App\Enums\Utills\StatusEnum;
use App\Helpers\FileUpDownHelper;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\Web\Admin\Auth\AuthenticatedSessionController as AdminAuthController;
use App\Http\Controllers\Web\Admin\Auth\PasswordResetLinkController as AdminPasswordResetController;
use App\Http\Controllers\Web\Admin\CmsReportController as AdminCmsReportController;
use App\Http\Controllers\Web\Admin\Dashboard\DashboardController as AdminDashboardController;
use App\Http\Controllers\Web\Admin\InvestorController as AdminInvestorController;
use App\Http\Controllers\Web\Admin\Master\BankAccountTypeController as MasterBankAccountTypeController;
use App\Http\Controllers\Web\Admin\Master\BankController as MasterBankController;
use App\Http\Controllers\Web\Admin\Master\BlogController as MasterBlogController;
use App\Http\Controllers\Web\Admin\Master\CityController as MasterCityController;
use App\Http\Controllers\Web\Admin\Master\CountryController as MasterCountryController;
use App\Http\Controllers\Web\Admin\Master\FamilyRelationController as MasterFamilyRelationController;
use App\Http\Controllers\Web\Admin\Master\HeaderTokenController;
use App\Http\Controllers\Web\Admin\Master\IndustryController as MasterIndustryController;
use App\Http\Controllers\Web\Admin\Master\InstrumentTypeController as MasterInstrumentTypeController;
use App\Http\Controllers\Web\Admin\Master\InvestorTypeController as MasterInvestorTypeController;
use App\Http\Controllers\Web\Admin\Master\ManageInfoIconController as MasterManageInfoIconController;
use App\Http\Controllers\Web\Admin\Master\PagesController as MasterPagesController;
use App\Http\Controllers\Web\Admin\Master\SectorController as MasterSectorController;
use App\Http\Controllers\Web\Admin\Master\SocialMediaLinkController as MasterSocialMediaLinkController;
use App\Http\Controllers\Web\Admin\Master\StartupRoundTypeController as MasterStartupRoundTypeController;
use App\Http\Controllers\Web\Admin\Master\StateController as MasterStateController;
use App\Http\Controllers\Web\Admin\Master\WebsiteSocialMediaController as MasterWebsiteSocialMediaController;
use App\Http\Controllers\Web\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Web\Admin\ProfileMenu\NotificationController as AdminProfileNotificationController;
use App\Http\Controllers\Web\Admin\Partner\DistributorController as AdminPartnerDistributorController;
use App\Http\Controllers\Web\Admin\Partner\RetailersController as AdminPartnerRetailersController;
use App\Http\Controllers\Web\Admin\Partner\WealthManagerController as AdminPartnerWealthManagerController;
use App\Http\Controllers\Web\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Web\Admin\PrimaryTransactionController as AdminPrimaryTransactionController;
use App\Http\Controllers\Web\Admin\Setting\SettingController;
use App\Http\Controllers\Web\Admin\Startup\MGT14Controller as AdminMGT14Controller;
use App\Http\Controllers\Web\Admin\Startup\UpdateController as AdminStartupUpdateController;
use App\Http\Controllers\Web\Admin\Startup\MISController as AdminStartupMISController;
use App\Http\Controllers\Web\Admin\Startup\OfferRequestController as AdminOfferRequestController;
use App\Http\Controllers\Web\Admin\Startup\Pas3Controller as AdminPas3Controller;
use App\Http\Controllers\Web\Admin\StartupController;
use App\Http\Controllers\Web\Admin\WhatsappBroadcastController as AdminWhatsappBroadcastController;
use App\Http\Controllers\DynamicUrlController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Web\Admin\AdminApiClientsController;
use App\Http\Controllers\Web\Admin\AiAutowork\AiAutoworkController;
use App\Http\Controllers\Web\Admin\AiAutowork\AiCompanyIngestAdminController;
use App\Http\Controllers\Web\Admin\BseHolidayController;
use App\Http\Controllers\Web\Admin\CompanyController;
use App\Http\Controllers\Web\Admin\CompanyDealController;
use App\Http\Controllers\Web\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Web\Admin\ManagerController as AdminManagerController;
use App\Http\Controllers\Web\Admin\ManualController as AdminManualController;
use App\Http\Controllers\Web\Admin\Master\AvtarController as MasterAvtarController;
use App\Http\Controllers\Web\Admin\Master\FaqsController as MasterFaqsController;
use App\Http\Controllers\Web\Admin\Master\FindCmlController;
use App\Http\Controllers\Web\Admin\Master\ProjectController as MasterProjectController;
use App\Http\Controllers\Web\Admin\Master\ResourceBillingController;
use App\Http\Controllers\Web\Admin\Master\SupportedCountriesController as MasterSupportedCountriesController;
use App\Http\Controllers\Web\Admin\MyProfileController;
use App\Http\Controllers\Web\Admin\NotificationsController as AdminReportsNotificationsController;
use App\Http\Controllers\Web\Admin\Partner\RelationalManagerController as AdminRelationalManagerController;
use App\Http\Controllers\Web\Admin\PaymentReceiptController as AdminPaymentReceiptController;
use App\Http\Controllers\Web\Admin\PreIpoTransactionController as AdminPreIpoTransactionController;
use App\Http\Controllers\Web\Admin\PushNotificationController as AdminPushNotificationController;
use App\Http\Controllers\Web\Admin\SecondaryPaymentReceiptController as AdminSecondaryPaymentReceiptController;
use App\Http\Controllers\Web\Admin\SecondaryTransactionController as AdminSecondaryTransactionController;
use App\Http\Controllers\Web\Admin\CompanyEnquiryController as AdminCompanyEnquiryController;
use App\Http\Controllers\Web\Admin\SellerMasterController as AdminSellerMasterController;
use App\Http\Controllers\Web\Admin\Setting\AppVersionController;
use App\Http\Controllers\Web\Admin\Startup\LivepitchController as AdminStartupLivepitchController;
use App\Http\Controllers\Web\Admin\UploadDocumentController as AdminUploadDocumentController;
use App\Http\Controllers\Web\Admin\WebsiteController as AdminWebsiteController;
use App\Http\Controllers\Web\Front\User\Investor\DashboardController as InvestorDashboardController;
use App\Http\Controllers\Web\Front\User\Investor\MandateController;
use App\Http\Controllers\Web\Front\User\Investor\MISController as InvestorMISController;
use App\Http\Controllers\Web\Front\User\Investor\PortfolioController as InvestorPortfolioController;
use App\Http\Controllers\Web\Front\User\Investor\ProfileController as InvestorProfileController;
use App\Http\Controllers\Web\Front\User\Partner\ChannelPartnerController;
use App\Http\Controllers\Web\Front\User\Partner\CommonController as PartnerCommonController;
use App\Http\Controllers\Web\Front\User\Partner\DashboardController as PartnerDashboardController;
use App\Http\Controllers\Web\Front\User\PrimaryTransactionController as UsersPrimaryTransactionController;
use App\Http\Controllers\Web\Front\User\Startup\CommonController as StartupCommonController;
use App\Http\Controllers\Web\Front\User\Startup\DashboardController as StartupDashboardController;
use App\Http\Controllers\Web\Front\User\Startup\ManageCaptableController as StartupManageCaptableController;
use App\Http\Controllers\Web\Front\User\Startup\MISController as StartupMISController;
use App\Http\Controllers\Web\Front\User\Startup\StartupMgt14Controller as StartupMgt14Controller;
use App\Http\Controllers\Web\Front\User\Startup\Pas3Controller as StartupPas3Controller;
use App\Http\Controllers\Web\Front\User\Startup\SecondaryController as StartupSecondaryController;
use App\Http\Controllers\Web\Front\User\Startup\UpdatesController as StartupUpdatesController;
use App\Http\Controllers\Web\Front\WebsiteController as FrontWebsiteController;
use App\Http\Controllers\Web\SessionController;
use App\Http\Middleware\AdminRedirectIfAuthenticatedMiddleware;
use App\Http\Middleware\CoreMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\InvestorRedirectIfAuthenticatedMiddleware;
use App\Http\Middleware\InvestorRedirectIfNotAuthenticatedMiddleware;
use App\Http\Middleware\isMaintenanceMiddleware;
use App\Http\Middleware\isUserMiddleware;
use App\Http\Middleware\PartnerRedirectIfAuthenticatedMiddleware;
use App\Http\Middleware\PartnerRedirectIfNotAuthenticatedMiddleware;
use App\Http\Middleware\StartupRedirectIfAuthenticatedMiddleware;
use App\Http\Middleware\StartupRedirectIfNotAuthenticatedMiddleware;
use App\Http\Middleware\ValidateApiIframeAccess;
use App\Models\ApiClient;
use App\Models\InvestorModel;
use App\Models\PortfolioModel;
use App\Models\StartupModel;
use App\Models\StartupRoundModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
// use Maatwebsite\Excel\Excel;
use App\Models\ApiLogModel;
use App\Exports\TopActiveInvestorsExport;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Web\Admin\Setting\AppBuildController;
use App\Http\Controllers\Web\Website\SiteController;
use Maatwebsite\Excel\Facades\Excel;

// Route::get('sync-data', [TestController::class, 'syncData']);
Route::get('export-csv', [TestController::class, 'exportCSV']);

// SEO Routes
Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.xml');
Route::get('sitemap-news.xml', [SitemapController::class, 'news'])->name('sitemap.news.xml');

Route::group(['middleware' => [CoreMiddleware::class]], function () {
    // Route::get('test', [TestController::class, 'test']);

    Route::get('download-file', [DownloadController::class, 'web'])->name('download.web');
    Route::group(['middleware' => [isUserMiddleware::class]], function () {

        Route::post('notifications', [DownloadController::class, 'notifications'])->name('notifications');
    });

    Route::group(['middleware' => [isMaintenanceMiddleware::class]], function () {

        Route::name('front.')->group(function () {
            Route::get('', [FrontWebsiteController::class, 'index'])->name('home');
            Route::get('aboutus', [FrontWebsiteController::class, 'aboutus'])->name('abt');
            Route::get('smart-investing', [FrontWebsiteController::class, 'terminal'])->name('terminal');
            Route::get('disclaimer', [FrontWebsiteController::class, 'disclaimer'])->name('disclaimer');
            Route::get('privacy-policy', [FrontWebsiteController::class, 'privacyPolicy'])->name('privacypolicy');
            Route::get('terms-of-use', [FrontWebsiteController::class, 'termsOfUse'])->name('termsofuse');
            Route::get('risk-disclouser', [FrontWebsiteController::class, 'riskdisclouser'])->name('riskdisclouser');
            Route::get('team', [FrontWebsiteController::class, 'team'])->name('team');
            Route::get('download', [FrontWebsiteController::class, 'download'])->name('download');
            Route::get('cml-steps', [FrontWebsiteController::class, 'cmlSteps'])->name('cml.steps');

            Route::name('contactus.')->prefix('contactus')->group(function () {
                Route::get('', [FrontWebsiteController::class, 'contactus'])->name('get');
                Route::post('', [FrontWebsiteController::class, 'contactusSave'])->name('post');
            });

            Route::name('cards.')->group(function () {
                Route::get('startup', [FrontWebsiteController::class, 'startup'])->name('startup');
                Route::get('primary', [FrontWebsiteController::class, 'primary'])->name('primary');
                Route::get('secondary', [FrontWebsiteController::class, 'secondary'])->name('secondary');
                Route::get('private-equity', [FrontWebsiteController::class, 'preipo'])->name('preipo');
            });

            // Accept both slug and UUID for backward compatibility
            Route::get('company/{slugOrUuid}', [FrontWebsiteController::class, 'detail'])->name('company.detail');

            Route::prefix('inquiry')->name('inquiry.')->group(function () {
                Route::post('send-verification-code', [FrontWebsiteController::class, 'sendInquiryVerificationCode'])->name('sendCode');
                Route::post('verify-verification-code', [FrontWebsiteController::class, 'verifyInquiryVerificationCode'])->name('verifyCode');
            });

            Route::post('betatesting', [FrontWebsiteController::class, 'betaTesting'])->name('betatesting');
        });


        // Route::name('web.')->group(function () {
        //     Route::get('/', [SiteController::class, 'home'])->name('home');
        // });

        // Route::prefix('raise')->name('raise.')->group(function () {
        //     Route::group(['middleware' => [StartupRedirectIfNotAuthenticatedMiddleware::class]], function () {
        //         Route::get('dashboard', [StartupDashboardController::class, 'index'])->name('dashboard');
        //         Route::name('updates.')->prefix('updates')->group(function () {
        //             Route::get('', [StartupUpdatesController::class, 'list'])->name('list');
        //             Route::get('/{id}', [StartupUpdatesController::class, 'delete'])->name('delete');
        //             Route::post('', [StartupUpdatesController::class, 'save'])->name('save');
        //         });
        //         Route::name('mis.')->prefix('mis')->group(function () {
        //             Route::get('', [StartupMISController::class, 'list'])->name('list');
        //             Route::get('/{id}', [StartupMISController::class, 'delete'])->name('delete');
        //             Route::post('', [StartupMISController::class, 'save'])->name('save');
        //         });
        //         Route::name('changepassword.')->prefix('change-password')->group(function () {
        //             Route::get('', [StartupCommonController::class, 'changePassword'])->name('get');
        //             Route::post('', [StartupCommonController::class, 'changePasswordSave'])->name('post');
        //         });

        //         Route::get('primary-transaction', [UsersPrimaryTransactionController::class, 'list'])->name('primaryTransaction');
        //         Route::name('sell_requests.')->prefix('sell-request')->group(function () {
        //             Route::get('', [StartupSecondaryController::class, 'sellRequest'])->name('list');
        //             Route::get('status/{request}/{status}', [StartupSecondaryController::class, 'status'])->name('status');
        //         });
        //         Route::name('manageCaptable.')->prefix('manage-captable')->group(function () {
        //             Route::get('', [StartupManageCaptableController::class, 'list'])->name('list');
        //             Route::get('download', [StartupManageCaptableController::class, 'download'])->name('download');
        //             Route::get('add-share-holder', [StartupManageCaptableController::class, 'addShareHolder'])->name('addShareHolder');

        //             Route::post('save', [StartupManageCaptableController::class, 'saveManual'])->name('savemanual');

        //             Route::post('upload-captable', [StartupManageCaptableController::class, 'uploadExcel'])->name('upload');
        //         });
        //         Route::get('notifications', [StartupCommonController::class, 'notifications'])->name('notifications');

        //         Route::name('mgt14.')->prefix('mgt14')->group(function () {
        //             Route::get('', [StartupMgt14Controller::class, 'list'])->name('list');
        //             Route::get('create', [StartupMgt14Controller::class, 'showForm'])->name('create');
        //             Route::post('save', [StartupMgt14Controller::class, 'save'])->name('save');
        //         });


        //         Route::name('offerletter.')->prefix('offerletter')->group(function () {
        //             Route::get('request', [StartupCommonController::class, 'requestOffer'])->name('request');
        //             Route::get('send', [StartupCommonController::class, 'sendOffer'])->name('send');
        //         });

        //         Route::name('pas3.')->prefix('pas3')->group(function () {
        //             Route::get('', [StartupPas3Controller::class, 'list'])->name('list');
        //             Route::get('create', [StartupPas3Controller::class, 'showForm'])->name('create');
        //             Route::post('save', [StartupPas3Controller::class, 'save'])->name('save');
        //         });
        //         Route::get('document', [StartupCommonController::class, 'document'])->name('document');
        //         Route::get('logout', [StartupLoginController::class, 'logout'])->name('logout');
        //     });
        //     Route::get('', [HomeController::class, 'startupHome'])->name('home');
        //     Route::group(['middleware' => [StartupRedirectIfAuthenticatedMiddleware::class]], function () {
        //         Route::name('auth.')->group(function () {
        //             Route::get('login', [StartupLoginController::class, 'index'])->name('login');
        //             Route::get('apply', [StartupRegisterController::class, 'apply'])->name('apply');
        //             Route::get('forgot-password', [StartupPasswordResetController::class, 'index'])->name('forgot.get');

        //             Route::name('post.')->group(function () {
        //                 Route::post('login', [StartupLoginController::class, 'action'])->name('login');
        //                 Route::post('login-password', [StartupLoginController::class, 'changePassword'])->name('login.password');

        //                 Route::name('register.')->group(function () {
        //                     Route::post('details', [StartupRegisterController::class, 'detailsPost'])->name('details');
        //                     Route::post('funddetails', [StartupRegisterController::class, 'fundDetailsPost'])->name('funddetails');
        //                     Route::post('key-metrics', [StartupRegisterController::class, 'keyMetricsPost'])->name('keymetrics');
        //                     Route::post('finacial', [StartupRegisterController::class, 'financialDetails'])->name('financialdetails');
        //                     Route::post('other-details', [StartupRegisterController::class, 'otherDetails'])->name('otherdetails');

        //                     Route::post('mobile', [StartupRegisterController::class, 'mobilePost'])->name('mobile');
        //                     Route::post('resend-otp', [StartupRegisterController::class, 'resendOtp'])->name('resendotp');
        //                     Route::post('verify-otp', [StartupRegisterController::class, 'verifyOtp'])->name('verifyotp');
        //                     Route::post('set-password', [StartupRegisterController::class, 'setPassword'])->name('setPassword');
        //                     // Route::post('team', [StartupRegisterController::class, 'team'])->name('team');
        //                     // Route::post('details', [StartupRegisterController::class, 'details'])->name('details');
        //                     Route::post('documents', [StartupRegisterController::class, 'storeDocuments'])->name('documents');
        //                     // Route::post('social-media', [StartupRegisterController::class, 'socialmedia'])->name('socialmedia');
        //                 });

        //                 Route::name('forgot.')->prefix('forgot-password')->group(function () {
        //                     Route::post('', [StartupPasswordResetController::class, 'forgot'])->name('post');
        //                     Route::post('resend-otp', [StartupPasswordResetController::class, 'resendOtp'])->name('resendotp');
        //                     Route::post('verify-otp', [StartupPasswordResetController::class, 'verifyOtp'])->name('verifyotp');
        //                     Route::post('change-password', [StartupPasswordResetController::class, 'changePassword'])->name('changepassword');
        //                 });
        //             });
        //         });
        //     });
        // });

        // Route::name('pages.')->group(function () {
        //     //legal info
        //     Route::get('risk-warnings', [PagesController::class, 'riskwarings'])->name('riskwarnings');
        //     Route::get('privacy-notice', [PagesController::class, 'privacynotice'])->name('privacynotice');
        //     Route::get('terms-of-service', [PagesController::class, 'termsofservice'])->name('termsofservice');
        //     Route::get('how-to-invest', [PagesController::class, 'howtoinvest'])->name('howtoinvest');
        //     //about shuruup v4
        //     Route::get('about-us', [PagesController::class, 'aboutus'])->name('aboutus');
        //     Route::get('careers', [PagesController::class, 'careers'])->name('careers');
        //     Route::get('feedback', [PagesController::class, 'feedback'])->name('feedback');
        //     Route::get('contact-us', [PagesController::class, 'contactus'])->name('contactus');
        //     Route::post('feedback', [PagesController::class, 'feedbackSave'])->name('feedback.save');
        //     Route::post('contact-us', [PagesController::class, 'contactusSave'])->name('contact.save');
        //     Route::name('blog.')->prefix('insights')->group(function () {
        //         Route::get('', [PagesController::class, 'bloglist'])->name('list');
        //         Route::get('{slug}', [PagesController::class, 'blogview'])->name('view');
        //     });
        // });
    });
});

Route::get('preipo-investor', [AdminDashboardController::class, 'preIpoInvestor'])->name('preipo_investor');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('', function () {
        return redirect('admin/login');
    });

    Route::group(['middleware' => [App\Http\Middleware\AdminRedirectIfNotAuthenticatedMiddleware::class]], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::middleware('hasPermission:partner')->name('partner.')->prefix('partner')->group(function () {
            Route::name('wealthmanager.')->prefix('wealth-manager')->group(function () {
                Route::get('create', [AdminPartnerWealthManagerController::class, 'create'])->name('create');
                Route::get('list', [AdminPartnerWealthManagerController::class, 'list'])->name('list');
                Route::get('view/{uuid}', [AdminPartnerWealthManagerController::class, 'view'])->name('view');
                Route::get('edit/{uuid}', [AdminPartnerWealthManagerController::class, 'edit'])->name('edit');

                Route::post('save', [AdminPartnerWealthManagerController::class, 'store'])->name('store');
                Route::put('update/{uuid}', [AdminPartnerWealthManagerController::class, 'update'])->name('update');
                Route::delete('delete/{id}', [AdminPartnerWealthManagerController::class, 'delete'])->name('destroy');
            });

            Route::name('distributor.')->prefix('distributor')->group(function () {
                Route::get('list', [AdminPartnerDistributorController::class, 'list'])->name('list');
                Route::get('create', [AdminPartnerDistributorController::class, 'create'])->name('create');
                Route::get('view/{uuid}', [AdminPartnerDistributorController::class, 'view'])->name('view');
                Route::get('edit/{uuid}', [AdminPartnerDistributorController::class, 'edit'])->name('edit');

                Route::post('save', [AdminPartnerDistributorController::class, 'store'])->name('store');
                Route::put('update/{uuid}', [AdminPartnerDistributorController::class, 'update'])->name('update');
                Route::delete('delete/{id}', [AdminPartnerDistributorController::class, 'delete'])->name('destroy');
            });

            Route::name('retailers.')->prefix('retailers')->group(function () {
                Route::get('list', [AdminPartnerRetailersController::class, 'list'])->name('list');
                Route::get('create', [AdminPartnerRetailersController::class, 'create'])->name('create');
                Route::get('view/{uuid}', [AdminPartnerRetailersController::class, 'view'])->name('view');
                Route::get('update/{uuid}', [AdminPartnerRetailersController::class, 'edit'])->name('edit');

                Route::post('save', [AdminPartnerRetailersController::class, 'store'])->name('store');
                Route::put('update/{uuid}', [AdminPartnerRetailersController::class, 'update'])->name('update');
                Route::delete('delete/{id}', [AdminPartnerRetailersController::class, 'delete'])->name('destroy');
            });

            Route::name('relationalManager.')->prefix('relation-manager')->group(function () {
                Route::get('list', [AdminRelationalManagerController::class, 'list'])->name('list');
                Route::get('create', [AdminRelationalManagerController::class, 'create'])->name('create');
                Route::get('view/{uuid}', [AdminRelationalManagerController::class, 'view'])->name('view');
                Route::get('update/{uuid}', [AdminRelationalManagerController::class, 'edit'])->name('edit');

                Route::post('save', [AdminRelationalManagerController::class, 'store'])->name('store');
                Route::put('update/{uuid}', [AdminRelationalManagerController::class, 'update'])->name('update');
                Route::delete('delete/{id}', [AdminRelationalManagerController::class, 'delete'])->name('destroy');
            });

            Route::get('demo', [AdminPartnerWealthManagerController::class, 'list'])->name('demo');
            Route::get('mark-demo/{uuid}', [AdminPartnerWealthManagerController::class, 'markAsDemo'])->name('mark-demo');
            Route::post('manager', [AdminPartnerWealthManagerController::class, 'manager'])->name('manager');
        });

        Route::middleware('hasPermission:investor')->name('investor.')->prefix('investor')->group(function () {
            Route::get('create', [AdminInvestorController::class, 'create'])->name('create');
            Route::get('active', [AdminInvestorController::class, 'list'])->name('active');
            Route::get('inactive', [AdminInvestorController::class, 'list'])->name('inactive');
            Route::get('rejected', [AdminInvestorController::class, 'list'])->name('rejected');
            Route::get('demo', [AdminInvestorController::class, 'list'])->name('demo');
            Route::get('block', [AdminInvestorController::class, 'list'])->name('block');
            Route::get('filter', [AdminInvestorController::class, 'filteredList'])->name('filter');
            Route::get('aadhar-pan-verification', [AdminInvestorController::class, 'aadharPanVerification'])->name('aadharPanVerification');
            Route::get('export-excel', [AdminInvestorController::class, 'exportExcel'])->name('export');
            Route::get('pending-kyc', [AdminInvestorController::class, 'list'])->name('pendingkyc');
            // Global documents list for investors
            Route::get('documents', [AdminInvestorController::class, 'documents'])->name('documents');
            Route::get('documents/data', [AdminInvestorController::class, 'documentsData'])->name('documents.data');
            Route::get('processing-kyc', [AdminInvestorController::class, 'processingKyc'])->name('processing-kyc');
            Route::get('processing-kyc/data', [AdminInvestorController::class, 'processingKycData'])->name('processing-kyc.data');
            Route::post('submit-kyc', [AdminInvestorController::class, 'manualKycSubmit'])->name('manualKycSubmit');
            Route::post('reject-manual-kyc', [AdminInvestorController::class, 'manualKycReject'])->name('manualKycReject');
            Route::get('update/{uuid}', [AdminInvestorController::class, 'edit'])->name('edit');
            Route::get('active-status/{uuid}/{status}', [AdminInvestorController::class, 'activestatus'])->name('activestatus');
            Route::get('view/{uuid}', [AdminInvestorController::class, 'view'])->name('view');
            Route::get('mark-demo/{uuid}', [AdminInvestorController::class, 'markAsDemo'])->name('mark-demo');
            Route::get('mark-block/{uuid}', [AdminInvestorController::class, 'markBlock'])->name('markBlock');

            Route::post('store', [AdminInvestorController::class, 'store'])->name('store');
            Route::post('manager', [AdminInvestorController::class, 'manager'])->name('manager');
            Route::post('get-temp-aadhar-pan-details', [AdminInvestorController::class, 'getTempAadharPanDetails'])->name('getTempAadharPanDetails');
            Route::post('approve-aadhar-pan', [AdminInvestorController::class, 'approveAadharPan'])->name('approveAadharPan');
            Route::post('process-demat-pdf', [AdminInvestorController::class, 'processDematPdf'])->name('process-demat-pdf');
            Route::post('{uuid}/demat-kyc', [AdminInvestorController::class, 'storeDematKyc'])->name('demat-kyc.store');
            Route::put('update/{uuid}', [AdminInvestorController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [AdminInvestorController::class, 'delete'])->name('destroy');


            Route::name('manual-kyc.')->prefix('manual-kyc')->group(function () {
                Route::get('create/{uuid}', [AdminInvestorController::class, 'kycUpload'])->name('create');
                Route::post('save', [AdminInvestorController::class, 'kycUpload'])->name('save');
            });

            Route::name('manual-aif.')->prefix('manual-aif')->group(function () {
                Route::get('create/{uuid}', [AdminInvestorController::class, 'aifUpload'])->name('create');
                Route::post('save', [AdminInvestorController::class, 'aifUpload'])->name('save');
            });

            Route::get('edit-kyc/{uuid}', [AdminInvestorController::class, 'editKYCDetails'])->name('editKYCDetails');
            Route::post('update-kyc', [AdminInvestorController::class, 'updateKYCDetails'])->name('updateKYCDetails');
        });

        Route::middleware('hasPermission:manual kyc requests')->name('manualkyc.')->prefix('manual-kyc-request')->group(function () {
            Route::get('pending', [AdminInvestorController::class, 'manualKycPending'])->name('pending');
            Route::get('approved', [AdminInvestorController::class, 'manualKycApproved'])->name('approved');
            Route::get('rejected', [AdminInvestorController::class, 'manualKycRejected'])->name('rejected');
            Route::get('view/{uuid}', [AdminInvestorController::class, 'manualKycView'])->name('view');

            Route::get('reject-kyc/{id}', [AdminInvestorController::class, 'rejectManualKYC'])->name('reject');
            Route::post('approve-kyc', [AdminInvestorController::class, 'approveManualKYC'])->name('approve');
            Route::post('update-bank-status/{id}', [AdminInvestorController::class, 'updateBankStatus'])->name('updateBankStatus');
            Route::post('update-demat-status/{id}', [AdminInvestorController::class, 'updateDematStatus'])->name('updateDematStatus');
            Route::post('update-pan-status/{id}', [AdminInvestorController::class, 'updatePanStatus'])->name('updatePanStatus');
            Route::post('update-aadhar-status/{id}', [AdminInvestorController::class, 'updateAadharStatus'])->name('updateAadharStatus');
        });

        Route::middleware('hasPermission:aif onboard')->name('aifonboard.')->prefix('aif-onboard')->group(function () {
            Route::get('pending', [AdminInvestorController::class, 'aifOnboardPending'])->name('pending');
            Route::get('approved', [AdminInvestorController::class, 'aifOnboardApproved'])->name('approved');
            Route::get('rejected', [AdminInvestorController::class, 'aifOnboardRejected'])->name('rejected');
            Route::get('view/{uuid}', [AdminInvestorController::class, 'aifOnboardView'])->name('view');

            Route::post('status', [AdminInvestorController::class, 'aifOnboardapprove'])->name('approve');
            Route::get('document-status/{id}/{type}', [AdminInvestorController::class, 'aifDocumentStatus'])->name('documentstatus');
        });

        Route::middleware('hasPermission:primary payment receipt')->name('paymentReceipt.')->prefix('payment-receipt')->group(function () {
            Route::get('pending', [AdminPaymentReceiptController::class, 'pending'])->name('pending');
            Route::get('approved', [AdminPaymentReceiptController::class, 'approved'])->name('approved');
            Route::get('rejected', [AdminPaymentReceiptController::class, 'rejected'])->name('rejected');
            Route::get('approve_status/{id}', [AdminPaymentReceiptController::class, 'approve'])->name('approve');
            Route::get('reject_status/{id}', [AdminPaymentReceiptController::class, 'reject'])->name('reject');
        });

        Route::middleware('hasPermission:primary payment receipt')->name('secpaymentReceipt.')->prefix('secondary-payment-receipt')->group(function () {
            Route::get('pending', [AdminSecondaryPaymentReceiptController::class, 'pending'])->name('pending');
            Route::get('approved', [AdminSecondaryPaymentReceiptController::class, 'approved'])->name('approved');
            Route::get('rejected', [AdminSecondaryPaymentReceiptController::class, 'rejected'])->name('rejected');
            Route::get('approve_status/{id}', [AdminSecondaryPaymentReceiptController::class, 'approve'])->name('approve');
            Route::get('reject_status/{id}', [AdminSecondaryPaymentReceiptController::class, 'reject'])->name('reject');
        });

        Route::name('profile.')->prefix('profile')->group(function () {
            Route::name('notification.')->prefix('notification')->group(function () {
                Route::get('', [AdminProfileNotificationController::class, 'list'])->name('list');
            });
        });

        Route::middleware('hasPermission:primary transaction')->name('primarytransactions.')->prefix('primary-transactions')->group(function () {
            Route::get('pending', [AdminPrimaryTransactionController::class, 'list'])->name('pending');
            Route::get('completed', [AdminPrimaryTransactionController::class, 'list'])->name('completed');

            Route::delete('delete/{id}', [AdminPrimaryTransactionController::class, 'delete'])->name('delete');

            Route::name('uploadDocument.')->prefix('upload-document')->group(function () {
                // Route::get('list', [AdminWhatsappBroadcastController::class, 'list'])->name('list');
                Route::get('create', [AdminUploadDocumentController::class, 'create'])->name('create');
                // Route::get('view/{item}', [AdminWhatsappBroadcastController::class, 'view'])->name('view');
                Route::post('store', [AdminUploadDocumentController::class, 'store'])->name('store');
                Route::post('documents', [AdminUploadDocumentController::class, 'storeSingleTransactionDoc'])->name('storeSingleTransactionDoc');
                Route::post('sec-documents', [AdminUploadDocumentController::class, 'storeSingleSecTransactionDoc'])->name('storeSingleSecTransactionDoc');
                Route::post('preipo-documents', [AdminUploadDocumentController::class, 'storeSinglePreipoTransactionDoc'])->name('storeSinglePreipoTransactionDoc');
            });
        });

        Route::middleware('hasPermission:secondary transaction')->name('secondarytransactions.')->prefix('secondary-transactions')->group(function () {
            Route::get('pending', [AdminSecondaryTransactionController::class, 'list'])->name('pending');
            Route::get('completed', [AdminSecondaryTransactionController::class, 'list'])->name('completed');
        });

        Route::middleware('hasPermission:pre ipo transaction')->name('preipotransaction.')->prefix('pre-ipo-transactions')->group(function () {
            Route::get('status/{transaction_id}', [AdminPreIpoTransactionController::class, 'status'])->name('status');
            Route::get('market', [AdminPreIpoTransactionController::class, 'market'])->name('market');
            Route::get('pending', [AdminPreIpoTransactionController::class, 'list'])->name('pending');
            Route::get('rejected', [AdminPreIpoTransactionController::class, 'list'])->name('rejected');
            Route::get('completed', [AdminPreIpoTransactionController::class, 'list'])->name('completed');

            Route::get('slip-status/{transaction_id}', [AdminPreIpoTransactionController::class, 'slipStatus'])->name('slipStatus');
            Route::get('pre-ipo/download-deal-slip/{id}', [AdminPreIpoTransactionController::class, 'downloadDealSlip'])->name('downloadDealSlip');

            Route::get('resend-deal-slip/{transaction_id}', [AdminPreIpoTransactionController::class, 'resendDealSlip'])->name('resendDealSlip');
            Route::post('approve-transaction', [AdminPreIpoTransactionController::class, 'approveTransaction'])->name('approve');
            Route::delete('delete/{id}', [AdminPreIpoTransactionController::class, 'deletePreIpoTransaction'])->name('delete');
            Route::post('extend-timer/{transaction_id}', [AdminPreIpoTransactionController::class, 'extendTimer'])->name('extendTimer');
            Route::post('retrieve-transaction/{transaction_id}', [AdminPreIpoTransactionController::class, 'retrieveTransaction'])->name('retrieve');



            Route::name('uploadDocument.')->prefix('upload-document')->group(function () {
                Route::post('deal-slip', [AdminUploadDocumentController::class, 'storeSinglePreipoTransactionDoc'])->name('storeDealSlip');
            });
        });

        Route::name('secondarySellRequest.')->prefix('secondary-sell-request')->group(function () {
            Route::get('pending', [AdminSecondaryTransactionController::class, 'sellRequestList'])->name('pending');
            Route::get('in-progress', [AdminSecondaryTransactionController::class, 'sellRequestList'])->name('inProgress');
            Route::get('completed', [AdminSecondaryTransactionController::class, 'sellRequestList'])->name('completed');
            Route::delete('delete/{id}', [AdminSecondaryTransactionController::class, 'delete'])->name('destroy');
        });

        Route::name('companyEnquiry.')->prefix('company-enquiry')->group(function () {
            Route::get('pending', [AdminCompanyEnquiryController::class, 'list'])->name('pending');
            Route::get('completed', [AdminCompanyEnquiryController::class, 'list'])->name('completed');
            Route::post('{id}/complete', [AdminCompanyEnquiryController::class, 'complete'])->name('complete');
            Route::delete('delete/{id}', [AdminCompanyEnquiryController::class, 'delete'])->name('destroy');
        });

        Route::name('reports.')->prefix('reports')->group(function () {
            Route::middleware('hasPermission:cms reports')->name('cms.')->prefix('cms')->group(function () {
                Route::get('feedbacklist', [AdminCmsReportController::class, 'feedbacklist'])->name('feedback.list');
                Route::get('contactlist', [AdminCmsReportController::class, 'contactlist'])->name('contact.list');
                Route::get('contactlist/export-excel', [AdminCmsReportController::class, 'exportContactExcel'])->name('contact.export');
                Route::get('contactlist/view/{id}', [AdminCmsReportController::class, 'viewContact'])->name('contact.view');
                Route::delete('contactlist/delete/{id}', [AdminCmsReportController::class, 'deleteContact'])->name('contact.delete');
                Route::post('contactlist/bulk-delete', [AdminCmsReportController::class, 'bulkDeleteContact'])->name('contact.bulk-delete');
                Route::get('leads', [AdminCmsReportController::class, 'reportLeads'])->name('leads');
                Route::get('preipo-device-export', [AdminCmsReportController::class, 'preIpoDeviceExport'])->name('preipoDeviceExport');
                Route::name('requestaccess.')->prefix('request-access')->group(function () {
                    Route::get('pending', [AdminCmsReportController::class, 'requestAccessList'])->name('pending');
                    Route::get('completed', [AdminCmsReportController::class, 'requestAccessList'])->name('completed');
                    Route::post('mark-as-read', [AdminCmsReportController::class, 'markAsRead'])->name('markAsRead');
                });
            });

            Route::middleware('hasPermission:resource billing management')->name('resourceBilling.')->prefix('resource-billing')->group(function () {
                Route::get('list', [ResourceBillingController::class, 'list'])->name('list');
                Route::get('create', [ResourceBillingController::class, 'create'])->name('create');
                Route::post('store', [ResourceBillingController::class, 'store'])->name('store');
                Route::post('billing-history', [ResourceBillingController::class, 'billingHistory'])->name('createBillingHistory');
            });

            Route::name('notifications.')->prefix('notifications')->group(function () {
                Route::get('whatsapp', [AdminReportsNotificationsController::class, 'whatsappList'])->name('whatsappList');
                // Route::get('create', [ResourceBillingController::class, 'create'])->name('create');
                // Route::post('store', [ResourceBillingController::class, 'store'])->name('store');
                // Route::post('billing-history', [ResourceBillingController::class, 'billingHistory'])->name('createBillingHistory');
            });

            Route::middleware('hasPermission:application logs')->name('applogs.')->prefix('applogs')->group(function () {
                Route::name('investor.')->prefix('investor')->group(function () {
                    Route::get('android', [AdminCmsReportController::class, 'appLogs'])->name('android');
                    Route::get('ios', [AdminCmsReportController::class, 'appLogs'])->name('ios');
                    Route::get('windows', [AdminCmsReportController::class, 'appLogs'])->name('windows');
                    Route::name('active-today.')->prefix('active-today')->group(function () {
                        Route::get('list', [AdminCmsReportController::class, 'activeTodayList'])->name('list');
                        Route::get('view/{userid}/{usertype}/{date}', [AdminCmsReportController::class, 'activeTodayView'])->name('view');
                        // Route::get('view/{item}', [AdminWhatsappBroadcastController::class, 'view'])->name('view');
                    });
                });

                Route::name('distributer.')->prefix('distributer')->group(function () {
                    Route::get('android', [AdminCmsReportController::class, 'appLogs'])->name('android');
                    Route::get('ios', [AdminCmsReportController::class, 'appLogs'])->name('ios');
                    Route::get('windows', [AdminCmsReportController::class, 'appLogs'])->name('windows');
                    Route::name('active-today.')->prefix('active-today')->group(function () {
                        Route::get('list', [AdminCmsReportController::class, 'activeTodayList'])->name('list');
                        Route::get('view/{userid}/{usertype}/{date}', [AdminCmsReportController::class, 'activeTodayView'])->name('view');
                        // Route::get('view/{item}', [AdminWhatsappBroadcastController::class, 'view'])->name('view');
                    });
                });
            });
            // Route::get('request-beta-access', [AdminCmsReportController::class, 'requestBetaAccessList'])->name('requestbetaaccess.list');
        });



        Route::name('startup.')->prefix('startup')->group(function () {

            Route::name('updateteam.')->prefix('update-team')->group(function () {
                Route::get('{uuid}', [StartupController::class, 'editTeam'])->name('get');
                Route::post('', [StartupController::class, 'updateTeam'])->name('post');
            });

            Route::get('view/{uuid}', [StartupController::class, 'view'])->name('view');
            Route::get('view-old/{uuid}', [StartupController::class, 'viewOld'])->name('view.old');
            Route::get('create', [StartupController::class, 'create'])->name('create');
            Route::get('list', [StartupController::class, 'list'])->name('list');
            Route::post('store', [StartupController::class, 'store'])->name('store');
            // Route::post('store', [StartupController::class, 'store'])->name('store');
            Route::get('update/{uuid}', [StartupController::class, 'edit'])->name('edit');
            Route::get('edt/{uuid}', [StartupController::class, 'editet'])->name('editet');
            Route::post('update', [StartupController::class, 'update'])->name('update');

            Route::delete('delete/{id}', [StartupController::class, 'delete'])->name('destroy');
            Route::name('shareprice.')->prefix('share-price')->group(function () {
                Route::get('{uuid}', [StartupController::class, 'sharePrice'])->name('get');
                Route::get('delete/{id}', [StartupController::class, 'sharePriceDelete'])->name('delete');
                Route::post('', [StartupController::class, 'sharePriceSave'])->name('post');
            });
            Route::middleware('hasPermission:startup')->name('manage.')->prefix('manage')->group(function () {
                Route::get('pending', [StartupController::class, 'list'])->name('pending');
                Route::get('coming_soon', [StartupController::class, 'list'])->name('coming_soon');
                Route::get('raising_now', [StartupController::class, 'list'])->name('raising_now');
                Route::get('completed', [StartupController::class, 'list'])->name('completed');
            });

            Route::middleware('hasPermission:sm updates news')->name('update.')->prefix('update')->group(function () {
                Route::get('pending', [AdminStartupUpdateController::class, 'pending'])->name('pending');
                Route::get('approved', [AdminStartupUpdateController::class, 'approved'])->name('approved');
                Route::get('rejected', [AdminStartupUpdateController::class, 'rejected'])->name('rejected');

                Route::get('status/{id}/{status}', [AdminStartupUpdateController::class, 'status'])->name('status');
                Route::get('delete/{id}', [AdminStartupUpdateController::class, 'delete'])->name('delete');
            });

            Route::middleware('hasPermission:sm mgt14')->name('mgt14.')->prefix('mgt14')->group(function () {
                Route::get('pending', [AdminMGT14Controller::class, 'pending'])->name('pending');
                Route::get('approved', [AdminMGT14Controller::class, 'approved'])->name('approved');
                Route::get('rejected', [AdminMGT14Controller::class, 'rejected'])->name('rejected');
                Route::get('approve_status/{id}', [AdminMGT14Controller::class, 'approve'])->name('approve');
                Route::get('reject_status/{id}', [AdminMGT14Controller::class, 'reject'])->name('reject');
            });

            Route::middleware('hasPermission:sm offer request')->name('offerrequest.')->prefix('offerrequest')->group(function () {
                Route::get('pending', [AdminOfferRequestController::class, 'pending'])->name('pending');
                Route::get('approved', [AdminOfferRequestController::class, 'approved'])->name('approved');
                Route::get('rejected', [AdminOfferRequestController::class, 'rejected'])->name('rejected');
                Route::get('approve_status/{id}', [AdminOfferRequestController::class, 'approve'])->name('approve');
                Route::get('reject_status/{id}', [AdminOfferRequestController::class, 'reject'])->name('reject');
                Route::post('approve', [AdminOfferRequestController::class, 'approveSave'])->name('approveSave');
            });

            Route::middleware('hasPermission:sm pas3')->name('pas3.')->prefix('pas3')->group(function () {
                Route::get('pending', [AdminPas3Controller::class, 'pending'])->name('pending');
                Route::get('approved', [AdminPas3Controller::class, 'approved'])->name('approved');
                Route::get('rejected', [AdminPas3Controller::class, 'rejected'])->name('rejected');
                Route::get('approve_status/{id}', [AdminPas3Controller::class, 'approve'])->name('approve');
                Route::get('reject_status/{id}', [AdminPas3Controller::class, 'reject'])->name('reject');
            });

            Route::middleware('hasPermission:sm mis')->name('mis.')->prefix('mis')->group(function () {
                Route::get('create', [AdminStartupMISController::class, 'create'])->name('create');
                Route::get('pending', [AdminStartupMISController::class, 'pending'])->name('pending');
                Route::get('approved', [AdminStartupMISController::class, 'approved'])->name('approved');
                Route::get('rejected', [AdminStartupMISController::class, 'rejected'])->name('rejected');

                Route::post('save', [AdminStartupMISController::class, 'store'])->name('store');
                Route::get('status/{id}/{status}', [AdminStartupMISController::class, 'status'])->name('status');
                Route::get('delete/{id}', [AdminStartupMISController::class, 'delete'])->name('delete');
            });
            Route::middleware('hasPermission:sm live pitch')->resource('livepitch', AdminStartupLivepitchController::class);

            Route::get('edit-round/{round_id}', [StartupController::class, 'editRoundDetails'])->name('editRoundDetails');
            Route::post('update-round', [StartupController::class, 'updateRoundDetails'])->name('updateRoundDetails');
            Route::post('update-cms', [StartupController::class, 'updateCMS'])->name('updatecms');
        });

        Route::middleware('hasPermission:company')->name('coupon.')->prefix('coupon')->group(function () {
            Route::get('list', [AdminCouponController::class, 'list'])->name('list');
            Route::get('create', [AdminCouponController::class, 'create'])->name('create');
            Route::get('edit/{uuid}', [AdminCouponController::class, 'edit'])->name('edit');
            Route::post('store', [AdminCouponController::class, 'store'])->name('store');
            Route::put('update/{uuid}', [AdminCouponController::class, 'update'])->name('update');
            Route::delete('delete/{uuid}', [AdminCouponController::class, 'delete'])->name('delete');

            Route::get('settings', [AdminCouponController::class, 'settings'])->name('settings');
            Route::post('settings', [AdminCouponController::class, 'saveSettings'])->name('settings.save');
            Route::get('assign', [AdminCouponController::class, 'assignPage'])->name('assign');
            Route::post('assign', [AdminCouponController::class, 'assignToInvestors'])->name('assign.store');
        });

        Route::middleware('hasPermission:company')->name('bse-holiday.')->prefix('bse-holiday')->group(function () {
            Route::get('', [BseHolidayController::class, 'index'])->name('index');
            Route::get('list', [BseHolidayController::class, 'list'])->name('list');
            Route::get('create', [BseHolidayController::class, 'create'])->name('create');
            Route::post('store', [BseHolidayController::class, 'store'])->name('store');
            Route::get('edit/{uuid}', [BseHolidayController::class, 'edit'])->name('edit');
            Route::put('update/{uuid}', [BseHolidayController::class, 'update'])->name('update');
            Route::delete('delete/{uuid}', [BseHolidayController::class, 'destroy'])->name('delete');
            Route::patch('toggle-active/{uuid}', [BseHolidayController::class, 'toggleActive'])->name('toggleActive');
            Route::get('holidays-by-year', [BseHolidayController::class, 'getHolidaysByYear'])->name('getByYear');
            Route::post('bulk-import', [BseHolidayController::class, 'bulkImport'])->name('bulkImport');
        });

        Route::middleware('hasPermission:ai_autowork')->name('ai-autowork.')->prefix('ai-autowork')->group(function () {
            Route::get('', [AiAutoworkController::class, 'overview'])->name('overview');
            Route::get('company-ingest', [AiCompanyIngestAdminController::class, 'inbox'])->name('company-ingest.inbox');
            Route::get('company-ingest/guide', [AiCompanyIngestAdminController::class, 'guide'])->name('company-ingest.guide');
            Route::get('company-ingest/{uuid}', [AiCompanyIngestAdminController::class, 'review'])->name('company-ingest.review');
            Route::post('company-ingest/{uuid}', [AiCompanyIngestAdminController::class, 'update'])->name('company-ingest.update');
            Route::post('company-ingest/{uuid}/approve', [AiCompanyIngestAdminController::class, 'approve'])->name('company-ingest.approve');
            Route::post('company-ingest/{uuid}/reject', [AiCompanyIngestAdminController::class, 'reject'])->name('company-ingest.reject');
            Route::post('company-ingest/{uuid}/reopen', [AiCompanyIngestAdminController::class, 'reopen'])->name('company-ingest.reopen');
            Route::delete('company-ingest/{uuid}', [AiCompanyIngestAdminController::class, 'destroy'])->name('company-ingest.destroy');
            Route::get('share-prices', [AiAutoworkController::class, 'sharePricesStub'])->name('share-prices.stub');
            Route::get('share-prices/guide', [AiAutoworkController::class, 'sharePricesGuide'])->name('share-prices.guide');
        });

        Route::middleware('hasPermission:company')->name('company-deals.')->prefix('company-deals')->group(function () {
            Route::get('', [CompanyDealController::class, 'index'])->name('index');
            Route::get('list', [CompanyDealController::class, 'list'])->name('list');
            Route::get('create', [CompanyDealController::class, 'create'])->name('create');
            Route::post('store', [CompanyDealController::class, 'store'])->name('store');
            Route::get('edit/{uuid}', [CompanyDealController::class, 'edit'])->name('edit');
            Route::put('update/{uuid}', [CompanyDealController::class, 'update'])->name('update');
            Route::delete('delete/{uuid}', [CompanyDealController::class, 'destroy'])->name('delete');
        });

        Route::middleware('hasPermission:company')->name('company.')->prefix('company')->group(function () {
            Route::get('view/{uuid}', [CompanyController::class, 'view'])->name('view');
            Route::get('create', [CompanyController::class, 'create'])->name('create');
            Route::get('update-share-price', [CompanyController::class, 'updateSharePrice'])->name('updateSharePrice');
            Route::get('import', [CompanyController::class, 'import'])->name('import');
            Route::get('list', [CompanyController::class, 'list'])->name('list');
            Route::get('companyList', [CompanyController::class, 'getCompanies'])->name('companyList');
            Route::get('pending-seller', [CompanyController::class, 'pendingSellerCompanies'])->name('pendingSeller');
            Route::post('approve-seller/{uuid}', [CompanyController::class, 'approveSellerCompany'])->name('approveSeller');
            Route::post('reject-seller/{uuid}', [CompanyController::class, 'rejectSellerCompany'])->name('rejectSeller');

            Route::get('edit/{uuid}', [CompanyController::class, 'edit'])->name('edit');
            Route::get('delete/{uuid}', [CompanyController::class, 'delete'])->name('delete');
            Route::get('promoter/{uuid}', [CompanyController::class, 'promoter'])->name('promoter');
            Route::get('peer-ratio/{uuid}', [CompanyController::class, 'peerRatio'])->name('peerRatio');
            Route::get('share-price/{uuid}', [CompanyController::class, 'sharePrice'])->name('sharePrice');
            Route::delete('share-price/{uuid}/{id}', [CompanyController::class, 'sharePriceDelete'])->name('sharePriceDelete');
            Route::get('share-holders/{uuid}', [CompanyController::class, 'shareHolders'])->name('shareHolders');

            Route::get('financials-download/{uuid}', [CompanyController::class, 'financialsDownload'])->name('financialsDownload');
            Route::get('custom-data/{uuid}', [CompanyController::class, 'customData'])->name('customData');
            Route::get('event/{uuid}', [CompanyController::class, 'event'])->name('event');
            Route::get('news/{uuid}', [CompanyController::class, 'news'])->name('news');
            //excel download
            Route::get('download', [CompanyController::class, 'download'])->name('download');

            Route::post('upload-company-excel', [CompanyController::class, 'uploadCompanyExcel'])->name('ExcelDataSave');
            Route::post('update-share-price', [CompanyController::class, 'updateSharePriceSave'])->name('updateSharePriceSave');
            Route::post('process-ocr-financial-data', [CompanyController::class, 'processOcrFinancialData'])->name('processOcrFinancialData');
            Route::post('import', [CompanyController::class, 'importSave'])->name('import.save');
            Route::post('save', [CompanyController::class, 'save'])->name('save');
            Route::post('update', [CompanyController::class, 'update'])->name('update');
            Route::post('promoter', [CompanyController::class, 'promoterSave'])->name('promoterSave');
            Route::post('peer-ratio', [CompanyController::class, 'peerRatioSave'])->name('peerRatioSave');
            Route::post('share-price', [CompanyController::class, 'sharePriceSave'])->name('sharePriceSave');
            Route::post('share-holders', [CompanyController::class, 'shareHoldersSave'])->name('shareHoldersSave');
            Route::post('custom-data', [CompanyController::class, 'customDataSave'])->name('customDataSave');
            Route::post('event', [CompanyController::class, 'eventSave'])->name('eventSave');
            Route::post('news', [CompanyController::class, 'newsSave'])->name('newsSave');

            Route::get('get-financial-data', [CompanyController::class, 'getFinancialData'])
                ->name('get-financial-data');

            Route::post('update-financial-data', [CompanyController::class, 'updateFinancialData'])
                ->name('update-financial-data');

            Route::post('add-financial-year', [CompanyController::class, 'addFinancialYear'])
                ->name('add-financial-year');

            // Add these routes to your web.php or admin routes
            Route::post('/{id}/apply-split', [CompanyController::class, 'applySplit'])
                ->name('apply-split');

            Route::post('/{id}/revert-split', [CompanyController::class, 'revertSplit'])
                ->name('revert-split');

            Route::get('/{id}/split-history', [CompanyController::class, 'getSplitHistory'])
                ->name('split-history');

            // Route::post('financials-update', [CompanyController::class, 'updateFinancials'])->name('financials.update');
            Route::name('export.')->prefix('export')->group(function () {
                Route::get('', [CompanyController::class, 'exportView'])->name('view');
                Route::post('pdf', [CompanyController::class, 'exportPdf'])->name('pdf');
                Route::post('send-partner', [CompanyController::class, 'sendToPartner'])->name('send-partner');
                Route::post('send-demo', [CompanyController::class, 'sendToDemo'])->name('send-demo');
                Route::get('get-companies', [CompanyController::class, 'getCompaniesForVerification'])->name('get-companies');
            });
        });

        Route::middleware('hasPermission:seller')->name('preiposeller.')->prefix('seller')->group(function () {
            Route::get('create', [AdminSellerMasterController::class, 'create'])->name('create');
            Route::get('list', [AdminSellerMasterController::class, 'list'])->name('list');
            Route::post('save', [AdminSellerMasterController::class, 'save'])->name('save');
            Route::get('edit/{uuid}', [AdminSellerMasterController::class, 'edit'])->name('edit');
            Route::post('update/{uuid}', [AdminSellerMasterController::class, 'update'])->name('update');
            Route::delete('delete/{uuid}', [AdminSellerMasterController::class, 'delete'])->name('delete');
        });

        Route::middleware('hasPermission:portfolio')->name('portfolioInsights.')->prefix('portfolio-insights')->group(function () {
            Route::name('startupPortfolio.')->prefix('startup-portfolio')->group(function () {
                Route::get('list', [AdminPortfolioController::class, 'list'])->name('list');
                Route::get('view/{id}', [AdminPortfolioController::class, 'view'])->name('view');
            });
            Route::name('preIpoPortfolio.')->prefix('pre-ipo-portfolio')->group(function () {
                Route::get('list', [AdminPortfolioController::class, 'preIpoList'])->name('list');
            });
            Route::get('porfolio-upload-request', [AdminPortfolioController::class, 'portfolioUploadRequest'])->name('portfolioUploadRequest');
        });



        Route::middleware('hasPermission:masters')->name('master.')->prefix('master')->group(function () {
            Route::resource('supported-countries', MasterSupportedCountriesController::class);
            Route::resource('country', MasterCountryController::class);
            Route::resource('state', MasterStateController::class);
            Route::resource('city', MasterCityController::class);
            Route::resource('bank', MasterBankController::class);
            Route::resource('bank-account-type', MasterBankAccountTypeController::class);
            Route::resource('family-relation', MasterFamilyRelationController::class);
            Route::resource('investor-type', MasterInvestorTypeController::class);
            Route::resource('startup-round-type', MasterStartupRoundTypeController::class);
            Route::resource('instrument-type', MasterInstrumentTypeController::class);
            Route::resource('industry', MasterIndustryController::class);
            Route::resource('sector', MasterSectorController::class);
            Route::resource('project', MasterProjectController::class);
            Route::resource('social-media', MasterSocialMediaLinkController::class);
            Route::name('headertoken.')->prefix('headertoken')->group(function () {
                Route::get('list', [HeaderTokenController::class, 'list'])->name('list');
                Route::get('create', [HeaderTokenController::class, 'create'])->name('create');
                Route::get('delete/{id}', [HeaderTokenController::class, 'delete'])->name('delete');
            });
            Route::prefix('find-cml')->name('findcml.')->group(function () {
                Route::get('list', [FindCmlController::class, 'list'])->name('list');
                Route::get('create', [FindCmlController::class, 'create'])->name('create');
                Route::post('store', [FindCmlController::class, 'store'])->name('store');
                Route::get('edit/{uuid}', [FindCmlController::class, 'edit'])->name('edit');
                Route::put('update/{uuid}', [FindCmlController::class, 'update'])->name('update');
                Route::delete('delete/{id}', [FindCmlController::class, 'delete'])->name('delete');
            });
        });

        Route::middleware('hasPermission:cms management')->name('cms.')->prefix('cms')->group(function () {
            Route::resource('blog', MasterBlogController::class);
            Route::resource('avtar', MasterAvtarController::class);
            Route::resource('website-social-media', MasterWebsiteSocialMediaController::class);
            Route::resource('pages', MasterPagesController::class);
            Route::resource('manage-info-icon', MasterManageInfoIconController::class);
            Route::resource('faqs', MasterFaqsController::class);

            Route::name('media.')->prefix('media')->group(function () {
                Route::get('create', [AdminWebsiteController::class, 'create'])->name('create');
                Route::get('list', [AdminWebsiteController::class, 'list'])->name('list');

                Route::post('store', [AdminWebsiteController::class, 'store'])->name('store');
                Route::delete('delete/{id}', [AdminWebsiteController::class, 'delete'])->name('destroy');
            });
        });

        Route::middleware('hasPermission:broadcast')->name('broadcast.')->prefix('broadcast')->group(function () {
            Route::name('whatsapp.')->prefix('whatsapp')->group(function () {
                Route::get('list', [AdminWhatsappBroadcastController::class, 'list'])->name('list');
                Route::get('create', [AdminWhatsappBroadcastController::class, 'create'])->name('create');
                Route::get('view/{item}', [AdminWhatsappBroadcastController::class, 'view'])->name('view');

                // Used by broadcast create page to auto-select investors who invested in a startup
                Route::get('invested-investors', [AdminWhatsappBroadcastController::class, 'investedInvestors'])->name('investedInvestors');

                Route::get('download', [AdminWhatsappBroadcastController::class, 'downloadGuestTemplate'])->name('downloadGuestTemplate');
                Route::post('upload-guest-excel', [AdminWhatsappBroadcastController::class, 'uploadGuestExcel'])->name('uploadGuestExcel');
                Route::post('store', [AdminWhatsappBroadcastController::class, 'store'])->name('store');
                Route::post('resend/{item}', [AdminWhatsappBroadcastController::class, 'resend'])->name('resend');
                Route::post('cancel/{item}', [AdminWhatsappBroadcastController::class, 'cancel'])->name('cancel');
            });
            Route::get('notification-list', [AdminWhatsappBroadcastController::class, 'notificationlist'])->name('notificationlist');
            Route::name('pushNotification.')->prefix('push-notification')->group(function () {
                Route::get('list', [AdminPushNotificationController::class, 'list'])->name('list');
                Route::get('create', [AdminPushNotificationController::class, 'create'])->name('create');
                Route::get('view/{item}', [AdminPushNotificationController::class, 'view'])->name('view');
                Route::post('store', [AdminPushNotificationController::class, 'store'])->name('store');
            });
        });

        Route::name('news-assignment.')->prefix('news-assignment')->group(function () {
            Route::get('', [\App\Http\Controllers\Web\Admin\NewsAssignmentController::class, 'index'])->name('index');
            Route::get('company/{uuid}', [\App\Http\Controllers\Web\Admin\NewsAssignmentController::class, 'newsList'])->name('newsList');
            Route::post('news/{id}/change-company', [\App\Http\Controllers\Web\Admin\NewsAssignmentController::class, 'updateNewsCompany'])->name('updateNewsCompany');
            Route::post('news/bulk-delete', [\App\Http\Controllers\Web\Admin\NewsAssignmentController::class, 'deleteBulkNews'])->name('deleteBulkNews');
            Route::delete('news/{id}/delete', [\App\Http\Controllers\Web\Admin\NewsAssignmentController::class, 'deleteNews'])->name('deleteNews');
        });



        Route::name('systemConfiguration.')->prefix('system-configuration')->group(function () {
            Route::middleware('hasPermission:system settings')->name('systemSettings.')->prefix('system-settings')->group(function () {
                Route::get('', [SettingController::class, 'index'])->name('get');
                Route::post('', [SettingController::class, 'store'])->name('post');
            });
            Route::resource('apiclient', AdminApiClientsController::class);
            Route::middleware('hasPermission:app version control')->name('appVersionControl.')->prefix('app-version-control')->group(function () {
                Route::get('list', [AppVersionController::class, 'list'])->name('list');
                Route::get('create', [AppVersionController::class, 'create'])->name('create');
                Route::post('store', [AppVersionController::class, 'store'])->name('store');
            });
            Route::prefix('app-build')->name('appbuild.')->group(function () {
                Route::get('list', [AppBuildController::class, 'list'])->name('list');
                Route::get('create', [AppBuildController::class, 'create'])->name('create');
                Route::post('store', [AppBuildController::class, 'store'])->name('store');
                Route::get('download/{uuid}', [AppBuildController::class, 'download'])->name('download');
                Route::delete('delete/{id}', [AppBuildController::class, 'delete'])->name('delete');
            });
        });


        Route::post('logout', [AdminAuthController::class, 'destroy'])->name('logout');

        Route::middleware('hasPermission:master admin')->name('user-management.')->group(function () {
            Route::resource('/user-management/users', AdminDashboardController::class);
            Route::resource('/user-management/roles', AdminDashboardController::class);
            Route::resource('/user-management/permissions', AdminDashboardController::class);
        });

        Route::middleware('hasPermission:master admin')->name('manager.')->prefix('manager')->group(function () {
            Route::get('list', [AdminManagerController::class, 'list'])->name('list');
            Route::get('create', [AdminManagerController::class, 'create'])->name('create');
            Route::get('update/{uuid}', [AdminManagerController::class, 'edit'])->name('edit');
            Route::post('store', [AdminManagerController::class, 'store'])->name('store');
            Route::put('update/{uuid}', [AdminManagerController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [AdminManagerController::class, 'delete'])->name('destroy');
        });

        Route::name('myprofile.')->prefix('profile')->group(function () {
            Route::get('view', [MyProfileController::class, 'view'])->name('view');
            Route::get('update', [MyProfileController::class, 'edit'])->name('edit');
            Route::put('update', [MyProfileController::class, 'update'])->name('update');
        });

        Route::name('manual.')->prefix('manual')->group(function () {
            Route::middleware('hasPermission:manual secondary market')->name('secondary-market.')->prefix('secondary-market')->group(function () {
                Route::get('create', [AdminManualController::class, 'create'])->name('create');
                Route::post('save', [AdminManualController::class, 'save'])->name('save');
            });

            Route::middleware('hasPermission:manual preipo transaction')->name('preipo-transaction.')->prefix('preipo-transaction')->group(function () {
                Route::get('create', [AdminManualController::class, 'preIpoCreate'])->name('create');
                Route::post('save', [AdminManualController::class, 'preIpoSave'])->name('save');
            });

            Route::middleware('hasPermission:manual secondary transaction')->name('secondary-transaction.')->prefix('secondary-transaction')->group(function () {
                Route::get('create', [AdminManualController::class, 'secondaryCreate'])->name('create');
                Route::post('save', [AdminManualController::class, 'secondarySave'])->name('save');
            });

            Route::middleware('hasPermission:manual primary transaction')->name('primary-transaction.')->prefix('primary-transaction')->group(function () {
                Route::get('create', [AdminManualController::class, 'primaryCreate'])->name('create');
                Route::post('save', [AdminManualController::class, 'primarySave'])->name('save');
            });
        });

        // EXTRAS
        Route::middleware('hasPermission:investor notifications')->name('notification.')->prefix('notification')->group(function () {
            Route::name('investor.')->prefix('investor')->group(function () {
                Route::get('create', [AdminNotificationController::class, 'create'])->name('create');
                Route::post('store', [AdminNotificationController::class, 'store'])->name('store');
            });
        });
    });

    // Auth Routes
    Route::group(['middleware' => [App\Http\Middleware\AdminRedirectIfAuthenticatedMiddleware::class]], function () {
        Route::get('login', [AdminAuthController::class, 'create'])->name('login');
        Route::get('register', [AdminAuthController::class, 'create'])->name('register');
        Route::get('forgot-password', [AdminPasswordResetController::class, 'create'])->name('password.request');
        Route::get('reset-password/{token}', [AdminAuthController::class, 'create'])->name('password.reset');

        Route::post('login', [AdminAuthController::class, 'store']);
        Route::post('register', [AdminAuthController::class, 'store']);
        Route::post('forgot-password', [AdminAuthController::class, 'store'])->name('password.email');
        Route::post('reset-password', [AdminAuthController::class, 'store'])->name('password.update');
    });
});
// });

// Route::get('preipo-action/{action}', [AdminPreIpoTransactionController::class, 'whatsappAction'])
//     ->name('preipotransaction.whatsappAction');
Route::get('test', [TestController::class, 'test']);


Route::get('chunk-file-upload', [TestController::class, 'chunkFileUpload']);
// Route::post('upload-chunk', [TestController::class, 'uploadChunk'])->name('upload.chunk');


// Route::get('test1', [TestController::class, 'test1']);
Route::get('getActiveInvestors', [TestController::class, 'exportActiveInvestors']);


Route::get('office-dashboard', [DynamicUrlController::class, 'dashboard'])->name('office.dashboard');
Route::get('daily-report', [TestController::class, 'showDailyReport'])->name('office.dailyReport');

Route::get('t/{token}', [DynamicUrlController::class, 'index']);

Route::post('/restore-session', [SessionController::class, 'restore'])->name('session.restore');


Route::get('/.well-known/apple-app-site-association', function () {
    echo "hello world";
    exit;
    $content = '{
        "applinks": {
            "apps": [],
            "details": [
                {
                    "appID": "YY46V62AC2.com.shuruup.investor",
                    "paths": ["/app/*"]
                }
            ]
        }
    }';

    return response($content)
        ->header('Content-Type', 'application/json')
        ->header('Cache-Control', 'public, max-age=3600')
        ->header('Access-Control-Allow-Origin', '*');
});

Route::get('/debug-aasa', function () {
    $filePath = public_path('app-redirection/apple-app-site-association');

    return response()->json([
        'file_path' => $filePath,
        'file_exists' => file_exists($filePath),
        'public_path' => public_path(),
        'directory_exists' => is_dir(public_path('app-redirection')),
        'directory_contents' => is_dir(public_path('app-redirection')) ? scandir(public_path('app-redirection')) : 'Directory not found'
    ]);
});

Route::middleware([ValidateApiIframeAccess::class])
    ->get('/iframe/home', function () {
        try {
            $startupConstraints = fn($query) => $query->where('registration_step', 6)->where('is_deleted', 0);
            $buildRoundQuery = fn($status) => StartupRoundModel::where('round_status', $status)
                ->with(['startup.city', 'startup.sector', 'startup.cms', 'startup.raising_round'])
                ->whereHas('startup', $startupConstraints)
                ->groupBy('startup_id')
                ->limit(20);

            $transformRoundData = function ($round, $isCompleted = false) {
                $startup = $round->startup;
                $data = $startup->toArray();
                $data['banner_url'] = FileUpDownHelper::getStartupBanner($startup);

                if ($isCompleted) {
                    $data['completion_date'] = $round->updated_at?->format('M Y') ?? 'Dec 2024';
                } else {
                    $data['investor_count'] = $startup->investor_count ?? 0;
                    $data['valuation'] = $startup->indicative_valuation ?? 0;
                    $data['round_size'] = $startup->raising_round?->fund_requirement ?? 0;
                }

                return $data;
            };

            $raisingNow = $buildRoundQuery(StartupPrimaryRoundStatusEnum::raisingnow->value)
                ->get()
                ->map(fn($round) => $transformRoundData($round));

            $completedCampaigns = $buildRoundQuery(StartupPrimaryRoundStatusEnum::completed->value)
                ->get()
                ->map(fn($round) => $transformRoundData($round, true));

            return view('iframe.home', [
                'data' => [
                    'raisingNow' => $raisingNow->toArray(),
                    'completedCampaigns' => $completedCampaigns->toArray()
                ]
            ]);
        } catch (Exception $e) {
            abort(500, 'Error fetching data: ' . $e->getMessage());
        }
    });

Route::middleware([ValidateApiIframeAccess::class])
    ->get('/iframe/startup/{id}', function ($id) {
        try {
            $startup = StartupModel::where('id', $id)
                ->with([
                    'faqs',
                    'socialMediaLinks.socialMediaType',
                    'teamMembers',
                    'city',
                    'country',
                    'state',
                    'pitches' => function ($query) {
                        $query->where('status', StatusEnum::approved);
                    },
                    'market' => function ($query) {
                        $query->where('status', 7);
                    },
                    'legalInfo',
                    'cms',
                    'industry',
                    'sector',
                    'raising_round',
                    'lastRounds',
                    'updates' => function ($query) {
                        $query->where('status', StatusEnum::approved);
                    },
                ])
                ->first();

            if (!$startup) {
                abort(404, 'Startup not found');
            }

            $portfolioData = PortfolioModel::select('investor_id', DB::raw('SUM(investment_amount) as total_invested'))
                ->where('startup_id', $id)
                ->groupBy('investor_id')
                ->with(['investor:id,name,profile_photo,profile_visibility'])
                ->get();

            $investors = [];
            foreach ($portfolioData as $portfolio) {
                if ($portfolio->investor) {
                    $investors[] = [
                        'name' => $portfolio->investor->name,
                        'profile_visibility' => $portfolio->investor->profile_visibility,
                        'profile_photo' => $portfolio->investor->profile_photo,
                        'total_invested' => $portfolio->total_invested
                    ];
                }
            }

            $startup->portfolio = $investors;
            $startupData = json_decode(json_encode($startup), true);

            if (isset($startupData['bg_color_code'])) {
                $startupData['bg_color_code'] = sprintf('%06s', $startup->getRawOriginal('bg_color_code'));
            }

            $startupData['banner_url'] = FileUpDownHelper::getStartupBanner($startup);
            $startupData['logo_url'] = FileUpDownHelper::get_startup_logo_url($startup);
            $startupData['location'] = $startup->city?->name ?? 'Not specified';
            $startupData['total_investors'] = count($investors);

            if (isset($startupData['last_rounds']) && $startupData['last_rounds']) {
                $lastRound = $startupData['last_rounds'];
                $startupData['round_type'] = $lastRound['round_type'] ?? 'Not specified';
                $startupData['equity_offered'] = $lastRound['equity_offered'] ?? null;
                $startupData['floor'] = $lastRound['floor'] ?? null;
                $startupData['cap'] = $lastRound['cap'] ?? null;
            } else {
                $startupData['round_type'] = 'Not specified';
                $startupData['equity_offered'] = null;
                $startupData['floor'] = null;
                $startupData['cap'] = null;
            }

            if (isset($startupData['legal_info']['incorporation_date']) && $startupData['legal_info']['incorporation_date']) {
                try {
                    $startupData['legal_info']['incorporation_date'] = Carbon::parse($startupData['legal_info']['incorporation_date'])->format('d M Y');
                } catch (Exception $e) {
                    $startupData['legal_info']['incorporation_date'] = null;
                }
            }

            return view('iframe.startup-detail', compact('startupData', 'startup'));
        } catch (Exception $e) {
            abort(500, 'Error fetching data: ' . $e->getMessage());
        }
    });



// http://127.0.0.1:8000/iframe/home?access_token=secret123




Route::get('export-top-active-investors', function () {

    $records = ApiLogModel::query()
        ->join('investor', function ($join) {
            $join->on('api_logs.userid', '=', 'investor.id')
                ->where('investor.is_demo', 0)      // ✅ exclude demo users
                ->where('investor.is_deleted', 0);  // optional but recommended
        })

        ->where('api_logs.usertype', 'investor')
        ->whereNotNull('api_logs.userid')
        ->where('api_logs.userid', '!=', 0)
        ->where('api_logs.useragent', 'NOT LIKE', '%PostmanRuntime%')

        ->select(
            'api_logs.userid',
            'investor.name',
            'investor.mobile_number',
            'investor.email',

            DB::raw('COUNT(*) as total_activity'),
            DB::raw('MAX(api_logs.created_at) as last_active'),
            DB::raw("
                GROUP_CONCAT(DISTINCT 
                    CASE 
                        WHEN api_logs.devicetype='android' THEN 'Android'
                        WHEN api_logs.devicetype='ios' THEN 'iOS'
                        WHEN api_logs.devicetype='desktop' THEN 'Windows'
                    END
                ) as devices
            ")
        )
        ->groupBy(
            'api_logs.userid',
            'investor.name',
            'investor.mobile_number',
            'investor.email'
        )
        ->orderByDesc('total_activity')
        ->limit(150)
        ->get();

    $data = $records->map(function ($row, $index) {
        return [
            $index + 1,
            $row->name,
            $row->mobile_number,
            $row->email,
            $row->devices,
            $row->total_activity,
            $row->last_active,
        ];
    })->toArray();

    return Excel::download(
        new TopActiveInvestorsExport($data),
        'top_150_active_investors.xlsx'
    );
});

Route::get('v2/investor/unique-stats', function () {

    // Step 1: Get logs
    $logs = ApiLogModel::where('url', 'like', '%/api/v2/%')
        ->where('usertype', 'investor')
        ->whereNotNull('userid')
        ->get(['userid', 'devicetype']);

    // Step 2: Unique user IDs (overall)
    $userIds = $logs->pluck('userid')->unique()->values();

    // Step 3: Total investors
    $investors = InvestorModel::whereIn('id', $userIds)
        ->where('is_deleted', 0)
        ->where('is_demo', 0)
        ->get(['id', 'name']);

    // Step 4: Group userIds by device
    $grouped = $logs->groupBy('devicetype')->map(function ($items) {
        return $items->pluck('userid')->unique()->values();
    });

    // Step 5: Android users
    $androidUsers = isset($grouped['android'])
        ? InvestorModel::whereIn('id', $grouped['android'])
        ->where('is_deleted', 0)
        ->where('is_demo', 0)
        ->get(['id', 'name'])
        : collect();

    // Step 6: iOS users
    $iosUsers = isset($grouped['ios'])
        ? InvestorModel::whereIn('id', $grouped['ios'])
        ->where('is_deleted', 0)
        ->where('is_demo', 0)
        ->get(['id', 'name'])
        : collect();

    // Step 7: HTML Output
    $html = "
        <h2>Total Investors Using New App: {$investors->count()}</h2>

        <div style='display:flex; gap:40px;'>

            <!-- Android -->
            <div style='flex:1;'>
                <h3>Android Users ({$androidUsers->count()})</h3>
                <ul style='
                    column-count: 3;
                    column-gap: 20px;
                    list-style: none;
                    padding: 0;
                '>
            ";

    foreach ($androidUsers as $user) {
        $html .= "<li style='break-inside: avoid; padding:5px 0;'>{$user->name}</li>";
    }

    $html .= "
                </ul>
            </div>

            <!-- iOS -->
            <div style='flex:1;'>
                <h3>iOS Users ({$iosUsers->count()})</h3>
                <ul style='
                    column-count: 3;
                    column-gap: 20px;
                    list-style: none;
                    padding: 0;
                '>
            ";

    foreach ($iosUsers as $user) {
        $html .= "<li style='break-inside: avoid; padding:5px 0;'>{$user->name}</li>";
    }

    $html .= "
                </ul>
            </div>

        </div>
    ";

    return $html;
});

Route::get('v2/investor/detailed-stats', function () {

    // Step 1: Get new app users (API v2 logs) - excluding demo investors
    $newAppLogs = ApiLogModel::where('url', 'like', '%/api/v2/%')
        ->where('usertype', 'investor')
        ->whereNotNull('userid')
        ->get(['userid', 'devicetype']);

    $logUserIds = $newAppLogs->pluck('userid')->unique()->values();

    // Filter to only non-demo investors
    $newAppUserIds = InvestorModel::whereIn('id', $logUserIds)
        ->where('is_deleted', 0)
        ->where('is_demo', 0)
        ->pluck('id')
        ->values();

    // Step 2: Get all active non-demo investors
    $allInvestors = InvestorModel::where('is_deleted', 0)
        ->where('is_demo', 0)
        ->get(['id', 'name']);

    // Step 3: Get old app users (investors NOT in new app logs)
    $oldAppUserIds = $allInvestors->pluck('id')->diff($newAppUserIds)->values();

    // Step 4: Group new app users by device and filter by non-demo
    $groupedByDevice = $newAppLogs->groupBy('devicetype')->map(function ($items) {
        return $items->pluck('userid')->unique()->values();
    });

    $androidLogIds = isset($groupedByDevice['android']) ? $groupedByDevice['android'] : collect();
    $iosLogIds = isset($groupedByDevice['ios']) ? $groupedByDevice['ios'] : collect();

    // Filter to only non-demo investors for each device
    $androidIds = InvestorModel::whereIn('id', $androidLogIds)
        ->where('is_deleted', 0)
        ->where('is_demo', 0)
        ->pluck('id')
        ->values();

    $iosIds = InvestorModel::whereIn('id', $iosLogIds)
        ->where('is_deleted', 0)
        ->where('is_demo', 0)
        ->pluck('id')
        ->values();

    // Step 5: Function to check if investor has transactions
    $hasTransactions = function ($investorId) {
        return PortfolioModel::where('investor_id', $investorId)->exists();
    };

    // Step 6: Reorganize data - for each investor, track devices and transaction status
    $newAppInvestorsData = []; // investor_id => ['investor' => obj, 'devices' => [android, ios], 'hasTransactions' => bool]

    foreach ($newAppUserIds as $id) {
        $investor = InvestorModel::find($id, ['id', 'name']);
        if ($investor) {
            $devices = [];
            if ($androidIds->contains($id)) $devices[] = 'android';
            if ($iosIds->contains($id)) $devices[] = 'ios';

            $newAppInvestorsData[$id] = [
                'investor' => $investor,
                'devices' => $devices,
                'hasTransactions' => $hasTransactions($id)
            ];
        }
    }

    // Separate by transaction status
    $newAppWithTrans = array_filter($newAppInvestorsData, fn($d) => $d['hasTransactions']);
    $newAppNoTrans = array_filter($newAppInvestorsData, fn($d) => !$d['hasTransactions']);

    // Step 7: Categorize old app users by transaction status
    $oldAppWithTrans = [];
    $oldAppNoTrans = [];
    foreach ($oldAppUserIds as $id) {
        $investor = InvestorModel::find($id, ['id', 'name']);
        if ($investor) {
            if ($hasTransactions($id)) {
                $oldAppWithTrans[] = $investor;
            } else {
                $oldAppNoTrans[] = $investor;
            }
        }
    }

    // Step 8: Generate HTML with statistics
    $totalNewAppUsers = count($newAppUserIds);
    $totalOldAppUsers = count($oldAppUserIds);
    $totalNewAppWithTrans = count($newAppWithTrans);
    $totalNewAppNoTrans = count($newAppNoTrans);
    $totalOldAppWithTrans = count($oldAppWithTrans);
    $totalOldAppNoTrans = count($oldAppNoTrans);

    $html = "
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
            .container { max-width: 1400px; margin: 0 auto; }
            .summary { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
            .stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px; }
            .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
            .stat-title { font-size: 18px; font-weight: bold; margin-bottom: 15px; color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
            .stat-value { font-size: 32px; font-weight: bold; color: #007bff; margin: 10px 0; }
            .stat-label { font-size: 14px; color: #666; }
            .user-list { list-style: none; padding: 0; margin: 10px 0; }
            .user-list li { padding: 8px 0; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
            .user-list li:last-child { border-bottom: none; }
            .device-badge { display: inline-flex; gap: 4px; font-size: 11px; }
            .device-badge span { background: #e9ecef; padding: 2px 6px; border-radius: 3px; }
            .device-badge span.android { background: #c8e6c9; color: #2e7d32; }
            .device-badge span.ios { background: #bbdefb; color: #1565c0; }
            .section-title { font-size: 20px; font-weight: bold; color: #333; margin: 20px 0 10px 0; }
            .summary-title { font-size: 24px; font-weight: bold; color: #333; margin-bottom: 20px; }
            .columns { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px; }
            .column { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
            .column-title { font-weight: bold; font-size: 16px; margin-bottom: 10px; color: #333; border-bottom: 2px solid #28a745; padding-bottom: 8px; }
            .new-app { border-top: 5px solid #007bff; }
            .old-app { border-top: 5px solid #ff6c00; }
            .with-trans { background-color: #f0f7ff; }
            .no-trans { background-color: #fff5f0; }
            .count-badge { display: inline-block; background: #007bff; color: white; padding: 5px 10px; border-radius: 20px; font-weight: bold; margin-left: 10px; }
        </style>

        <div class='container'>
            <div class='summary'>
                <div class='summary-title'>📊 Investor App Usage & Transaction Analysis</div>
                
                <div class='stats-grid'>
                    <div class='stat-card new-app'>
                        <div class='stat-title'>🆕 New App Investors</div>
                        <div class='stat-value'>{$totalNewAppUsers}</div>
                        <div class='stat-label'>Using API v2 (Android + iOS)</div>
                        <hr style='border: none; border-top: 1px solid #ddd; margin: 10px 0;'>
                        <div style='font-size: 13px; color: #555;'>
                            <div>✅ With Transactions: <strong style='color: #28a745;'>{$totalNewAppWithTrans}</strong></div>
                            <div>❌ Without Transactions: <strong style='color: #dc3545;'>{$totalNewAppNoTrans}</strong></div>
                        </div>
                    </div>

                    <div class='stat-card old-app'>
                        <div class='stat-title'>🏛️ Old App Investors</div>
                        <div class='stat-value'>{$totalOldAppUsers}</div>
                        <div class='stat-label'>Not Using New App</div>
                        <hr style='border: none; border-top: 1px solid #ddd; margin: 10px 0;'>
                        <div style='font-size: 13px; color: #555;'>
                            <div>✅ With Transactions: <strong style='color: #28a745;'>{$totalOldAppWithTrans}</strong></div>
                            <div>❌ Without Transactions: <strong style='color: #dc3545;'>{$totalOldAppNoTrans}</strong></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='section-title'>📱 NEW APP INVESTORS (API v2)</div>
            
            <div class='columns'>
                <div class='column new-app with-trans'>
                    <div class='column-title'>✅ New App - With Transactions <span class='count-badge'>" . count($newAppWithTrans) . "</span></div>
                    <ul class='user-list'>
                        " . (count($newAppWithTrans) > 0 ? implode('', array_map(function ($d) {
        $deviceBadges = implode('', array_map(function ($dev) {
            return $dev === 'android' ? "<span class='android'>🤖 Android</span>" : "<span class='ios'>🍎 iOS</span>";
        }, $d['devices']));
        return "<li>• {$d['investor']->name}<div class='device-badge'>{$deviceBadges}</div></li>";
    }, $newAppWithTrans)) : "<li style='color: #999;'>No investors</li>") . "
                    </ul>
                </div>

                <div class='column new-app no-trans'>
                    <div class='column-title'>❌ New App - Without Transactions <span class='count-badge'>" . count($newAppNoTrans) . "</span></div>
                    <ul class='user-list'>
                        " . (count($newAppNoTrans) > 0 ? implode('', array_map(function ($d) {
        $deviceBadges = implode('', array_map(function ($dev) {
            return $dev === 'android' ? "<span class='android'>🤖 Android</span>" : "<span class='ios'>🍎 iOS</span>";
        }, $d['devices']));
        return "<li>• {$d['investor']->name}<div class='device-badge'>{$deviceBadges}</div></li>";
    }, $newAppNoTrans)) : "<li style='color: #999;'>No investors</li>") . "
                    </ul>
                </div>
            </div>

            <div class='section-title'>🏛️ OLD APP INVESTORS (Not on API v2)</div>
            
            <div class='columns'>
                <div class='column old-app with-trans'>
                    <div class='column-title'>✅ Old App - With Transactions <span class='count-badge'>" . count($oldAppWithTrans) . "</span></div>
                    <ul class='user-list'>
                        " . (count($oldAppWithTrans) > 0 ? implode('', array_map(fn($u) => "<li>• {$u->name}</li>", $oldAppWithTrans)) : "<li style='color: #999;'>No investors</li>") . "
                    </ul>
                </div>

                <div class='column old-app no-trans'>
                    <div class='column-title'>❌ Old App - Without Transactions <span class='count-badge'>" . count($oldAppNoTrans) . "</span></div>
                    <ul class='user-list'>
                        " . (count($oldAppNoTrans) > 0 ? implode('', array_map(fn($u) => "<li>• {$u->name}</li>", $oldAppNoTrans)) : "<li style='color: #999;'>No investors</li>") . "
                    </ul>
                </div>
            </div>
        </div>
    ";

    return $html;
});

Route::get('v2/investor/unregistered-stats', function () {

    // Get API v2 logs from the last 10 days - including guest users (userid = 0 or NULL)
    $tenDaysAgo = Carbon::now()->subDays(10);
    $unregisteredLogs = ApiLogModel::where('url', 'like', '%/api/v2/%')
        ->where('usertype', 'investor')
        ->where(function ($query) {
            $query->whereNull('userid')
                ->orWhere('userid', 0);
        })
        ->where('created_at', '>=', $tenDaysAgo)
        ->get(['deviceid', 'devicetype']);

    // Get unique device IDs from unregistered/guest logs
    $uniqueDeviceIds = $unregisteredLogs->pluck('deviceid')->unique()->filter()->values();

    if ($uniqueDeviceIds->isEmpty()) {
        return response()->json([
            'total_unregistered_devices' => 0,
            'android_devices' => 0,
            'ios_devices' => 0,
            'total_activity' => 0,
            'period' => 'last 10 days'
        ]);
    }

    // Get registered device IDs (devices with registered users, userid > 0)
    $registeredDeviceIds = ApiLogModel::where('url', 'like', '%/api/v2/%')
        ->where('userid', '>', 0)
        ->pluck('deviceid')
        ->unique()
        ->filter()
        ->values();

    // Find truly unregistered devices (never registered with userid > 0)
    $trueUnregisteredDeviceIds = $uniqueDeviceIds->diff($registeredDeviceIds)->values();

    // Get logs only for truly unregistered devices
    $unregisteredLogsFiltered = $unregisteredLogs->filter(function ($log) use ($trueUnregisteredDeviceIds) {
        return $trueUnregisteredDeviceIds->contains($log->deviceid);
    });

    // Group by device type
    $groupedByDevice = $unregisteredLogsFiltered->groupBy('devicetype');

    $totalUnregisteredDevices = count($trueUnregisteredDeviceIds);
    $totalAndroidDevices = isset($groupedByDevice['android']) ? $groupedByDevice['android']->pluck('deviceid')->unique()->count() : 0;
    $totalIosDevices = isset($groupedByDevice['ios']) ? $groupedByDevice['ios']->pluck('deviceid')->unique()->count() : 0;
    $totalActivityCount = $unregisteredLogsFiltered->count();

    return response()->json([
        'total_unregistered_devices' => $totalUnregisteredDevices,
        'android_devices' => $totalAndroidDevices,
        'ios_devices' => $totalIosDevices,
        'total_activity' => $totalActivityCount,
        'period' => 'last 10 days'
    ]);
});
