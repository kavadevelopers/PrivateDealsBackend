<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterWebsiteSocialmediaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class WebsiteSocialMediaController extends Controller
{
    public function index()
    {
        setPageTitle('Website Social Media');
        $data['websitesocialmediaList'] = MasterWebsiteSocialmediaModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        addVendor('datatables');
        return view('admin.pages.cms.website_social_media')->with($data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $websitesocialmedia = new MasterWebsiteSocialmediaModel();
        $validation = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique($websitesocialmedia->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0');
                }),
            ],
            'icon' => [
                'required',
                'max:255',
                'string',
            ],
            'link' => [
                'required',
                'string',
            ],

            'display_order' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.cms.website-social-media.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $websitesocialmedia->name = $request->name;
        $websitesocialmedia->icon = $request->icon;
        $websitesocialmedia->link = $request->link;
        $websitesocialmedia->display_order = $request->display_order;
        $websitesocialmedia->save();

        AdminHelper::logPut('Created website social media cms', MasterWebsiteSocialmediaModel::class, $websitesocialmedia->id);

        return redirect()->route('admin.cms.website-social-media.index')
            ->with('success', 'Website Social Media created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $item = MasterWebsiteSocialmediaModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Website Social Media');
            $data['item'] = $item;
            $data['websitesocialmediaList'] = MasterWebsiteSocialmediaModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('datatables');
            return view('admin.pages.cms.website_social_media')->with($data);
        }

        return redirect()->route('admin.cms.website-social-media.index')
            ->with('error', 'Item not found');
    }

    public function update(Request $request, string $id)
    {
        $item = MasterWebsiteSocialmediaModel::where('is_deleted', '0')->find($id);
        if ($item) {
            $validation = Validator::make($request->all(), [
                'name' => [
                    'required',
                    'max:255',
                    'string',
                    Rule::unique($item->getTable())->where(function ($query) use ($item) {
                        return $query->where('is_deleted', '0')->where('id', '!=', $item->id);
                    }),
                ],
                'icon' => [
                    'required',
                    'max:255',
                    'string',
                ],
                'link' => [
                    'required',
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

            $item->name = $request->name;
            $item->icon = $request->icon;
            $item->link = $request->link;
            $item->display_order = $request->display_order;
            $item->update();

            AdminHelper::logPut('Updated website social media cms', MasterWebsiteSocialmediaModel::class, $item->id);

            return redirect()->route('admin.cms.website-social-media.index')
                ->with('success', 'Website Social Media Updated Successfully.');
        }

        return redirect()->route('admin.cms.website-social-media.index')
            ->with('error', 'Item Not Found');
    }

    public function destroy(string $id)
    {
        $item = MasterWebsiteSocialmediaModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $item->is_deleted = '1';
            $item->update();

            AdminHelper::logPut('Deleted website social media cms', MasterWebsiteSocialmediaModel::class, $item->id);

            return redirect()->route('admin.cms.website-social-media.index')
                ->with('success', 'Website Social Media deleted successfully.');
        }

        return redirect()->route('admin.cms.website-social-media.index')
            ->with('error', 'Item not found');
    }
}
