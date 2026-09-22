<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\CmsFaqsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        setPageTitle('Masters FAQs');
        $data['list'] = CmsFaqsModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        addVendors(['datatables']);
        return view('admin.pages.cms.faqs')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $faqs = new CmsFaqsModel();
        $validation = Validator::make($request->all(), [
            'question' => [
                'required',
            ],
            'answer' => [
                'required',
            ],
            'category' => [
                'nullable',
                'string',
            ],
            'display_order' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.cms.faqs.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $faqs->question = $request->question;
        $faqs->answer = $request->answer;
        $faqs->category = $request->category;
        $faqs->display_order = $request->display_order;
        $faqs->save();

        AdminHelper::logPut('Created faqs CMS', CmsFaqsModel::class, $faqs->id);

        return redirect()->route('admin.cms.faqs.index')
            ->with('success', 'FAQs created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        $item = CmsFaqsModel::where('uuid', $uuid)->where('is_deleted', '0')->first();
        if ($item) {
            setPageTitle('CMS FQAs');
            $data['item'] = $item;
            $data['list'] = CmsFaqsModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('datatables');
            return view('admin.pages.cms.faqs')->with($data);
        }

        return redirect()->route('admin.cms.faqs.index')
            ->with('error', 'Item not found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        $item = CmsFaqsModel::where('uuid', $uuid)->where('is_deleted', '0')->first();
        if ($item) {
            $validation = Validator::make($request->all(), [
                'question' => [
                    'required',
                ],
                'answer' => [
                    'required',
                ],
                'category' => [
                    'nullable',
                    'string',
                ],
                'display_order' => [
                    'nullable',
                    'integer',
                    'min:1',
                ],
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withInput()
                    ->with('error', $validation->errors()->first());
            }
            $item->question = $request->question;
            $item->answer = $request->answer;
            $item->category = $request->category;
            $item->display_order = $request->display_order;
            $item->update();

            AdminHelper::logPut('Updated faqs CMS', CmsFaqsModel::class, $item->id);

            return redirect()->route('admin.cms.faqs.index')
                ->with('success', 'FAQs updated successfully.');
        }

        return redirect()->route('admin.cms.faqs.index')
            ->with('error', 'Item not found');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $item = CmsFaqsModel::where('uuid', $uuid)->where('is_deleted', '0')->first();

        if ($item) {
            $item->is_deleted = '1';
            $item->update();

            AdminHelper::logPut('Deleted faqs CMS', CmsFaqsModel::class, $item->id);

            return redirect()->route('admin.cms.faqs.index')
                ->with('success', 'FAQs deleted successfully.');
        }

        return redirect()->route('admin.cms.faqs.index')
            ->with('error', 'Item not found');
    }
}
