<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\CompanyEnquiryStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\CompanyEnquiryModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CompanyEnquiryController extends Controller
{
    public function list(Request $request): View
    {
        addVendor('datatables');

        $query = CompanyEnquiryModel::query()
            ->notDeleted()
            ->with(['company', 'deal', 'user'])
            ->orderByDesc('id');

        if ($request->routeIs('admin.companyEnquiry.pending')) {
            setPageTitle('Pending Company Enquiries');
            $query->pending();
        } else {
            setPageTitle('Completed Company Enquiries');
            $query->completed();
        }

        return view('admin.pages.company-enquiry.list', [
            'enquiries' => $query->get(),
        ]);
    }

    public function complete(string $id): RedirectResponse
    {
        $item = CompanyEnquiryModel::query()->notDeleted()->find($id);

        if (!$item) {
            return redirect()->route('admin.companyEnquiry.pending')
                ->with('error', 'Enquiry not found');
        }

        $item->status = CompanyEnquiryStatusEnum::completed->value;
        $item->save();

        return redirect()->route('admin.companyEnquiry.pending')
            ->with('success', 'Enquiry marked as completed.');
    }

    public function delete(string $id): RedirectResponse
    {
        $item = CompanyEnquiryModel::query()->notDeleted()->find($id);

        if (!$item) {
            return redirect()->route('admin.companyEnquiry.pending')
                ->with('error', 'Enquiry not found');
        }

        $item->is_deleted = true;
        $item->save();

        return redirect()->back()
            ->with('success', 'Enquiry deleted.');
    }
}
