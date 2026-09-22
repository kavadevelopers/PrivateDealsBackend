<?php

namespace App\Http\Controllers\Web\Admin;

use App\DataTables\NewsAssignmentDataTable;
use App\DataTables\NewsAssignmentNewsDataTable;
use App\Http\Controllers\Controller;
use App\Models\CompanyModel;
use App\Models\CompanyNewsModel;
use Illuminate\Http\Request;

class NewsAssignmentController extends Controller
{
    /**
     * Display a listing of the companies for news assignment.
     */
    public function index(NewsAssignmentDataTable $dataTable)
    {
        setPageTitle('News Assignment');
        return $dataTable->render('admin.pages.newsAssignment.list');
    }

    /**
     * Display a listing of the news for a specific company.
     */
    public function newsList(NewsAssignmentNewsDataTable $dataTable, $uuid)
    {
        $company = CompanyModel::where('uuid', $uuid)->firstOrFail();
        setPageTitle('News for ' . $company->brand_name);
        
        $companies = CompanyModel::select('id', 'brand_name')->where('is_deleted', '0')->orderBy('brand_name', 'asc')->get();
        
        return $dataTable->with('company_id', $company->id)->render('admin.pages.newsAssignment.news-list', compact('company', 'companies'));
    }

    /**
     * Update the assigned company for a specific news item.
     */
    public function updateNewsCompany(Request $request, $id)
    {
        $request->validate([
            'new_company_id' => 'required|exists:company,id',
        ]);

        $news = CompanyNewsModel::findOrFail($id);
        $news->company_id = $request->new_company_id;
        $news->save();

        return redirect()->back()->with('success', 'News reassigned successfully.');
    }

    /**
     * Delete a specific news item.
     */
    public function deleteNews($id)
    {
        $news = CompanyNewsModel::findOrFail($id);
        $news->delete();

        return redirect()->back()->with('success', 'News deleted successfully.');
    }

    /**
     * Delete multiple news items.
     */
    public function deleteBulkNews(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:company_news,id',
        ]);

        CompanyNewsModel::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => true]);
    }
}
