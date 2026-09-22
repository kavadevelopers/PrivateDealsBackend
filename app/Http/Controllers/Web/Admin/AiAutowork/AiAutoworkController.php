<?php

namespace App\Http\Controllers\Web\Admin\AiAutowork;

use App\Enums\TempCompanyStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\TempCompanyModel;
use Illuminate\View\View;

class AiAutoworkController extends Controller
{
    public function overview(): View
    {
        setPageTitle('AI AutoWork');
        $data['pendingCompanies'] = TempCompanyModel::where('status', TempCompanyStatusEnum::pending)->count();

        return view('admin.pages.ai-autowork.overview', $data);
    }

    public function sharePricesStub(): View
    {
        setPageTitle('AI Share Prices — Coming Soon');

        return view('admin.pages.ai-autowork.share-prices.stub');
    }

    public function sharePricesGuide(): View
    {
        setPageTitle('AI Guide — Share Prices (Coming Soon)');

        return view('admin.pages.ai-autowork.share-prices.guide');
    }
}
