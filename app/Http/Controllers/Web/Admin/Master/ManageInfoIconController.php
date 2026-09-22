<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterManageInfoIconModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ManageInfoIconController extends Controller
{
    public function index()
    {
        setPageTitle('Manage Info Icon');
        $data['list'] = MasterManageInfoIconModel::orderby('id', 'desc')->get();
        addVendor('datatables');
        return view('admin.pages.cms.manage_info_icon.list')->with($data);
    }

    public function create()
    {
        setPageTitle('Create Manage Info Icon');
        return view('admin.pages.cms.manage_info_icon.create');
    }

    public function store(Request $request)
    {
        $manageinfoicon = new MasterManageInfoIconModel();
        $validation = Validator::make($request->all(), [
            'title' => [
                'required',
                'string',

                // Rule::unique($manageinfoicon->getTable())->where(function ($query) use ($request) {
                //     return $query->where('is_deleted', '0');
                // }),
            ],
            'sub_title' => [
                'max:255',
                'string',
            ],
            'link_name' => [
                'max:255',
                'string',
            ],
            'link' => [
                'string',
            ],
            'description' => [
                'string',
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.cms.manage-info-icon.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $manageinfoicon->title = strtolower($request->title);
        $manageinfoicon->sub_title = $request->sub_title;
        $manageinfoicon->link_name = $request->link_name;
        $manageinfoicon->link = $request->link;
        $manageinfoicon->description = $request->description;
        $manageinfoicon->save();

        AdminHelper::logPut('Created cms info icons', MasterManageInfoIconModel::class, $manageinfoicon->id);

        return redirect()->route('admin.cms.manage-info-icon.index')
            ->with('success', 'Info Icon created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $item = MasterManageInfoIconModel::find($id);
        if ($item) {
            setPageTitle('Edit Manage Info Icon');
            $data['item'] = $item;
            $data['list'] = MasterManageInfoIconModel::orderby('id', 'desc')->get();
            addVendor('datatables');
            return view('admin.pages.cms.manage_info_icon.edit')->with($data);
        }

        return redirect()->route('admin.cms.manage-info-icon.index')
            ->with('error', 'Item not found');
    }

    public function update(Request $request, string $id)
    {
        $item = MasterManageInfoIconModel::find($id);
        if ($item) {
            $validation = Validator::make($request->all(), [
                'title' => [
                    'required',
                    'string',

                    // Rule::unique($manageinfoicon->getTable())->where(function ($query) use ($request) {
                    //     return $query->where('is_deleted', '0');
                    // }),
                ],
                'sub_title' => [
                    'max:255',
                    'string',
                ],
                'link_name' => [
                    'max:255',
                    'string',
                ],
                'link' => [
                    'string',
                ],
                'description' => [
                    'string',
                ],
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withInput()
                    ->with('error', $validation->errors()->first());
            }

            $item->title = strtolower($request->title);
            $item->sub_title = $request->sub_title;
            $item->link_name = $request->link_name;
            $item->link = $request->link;
            $item->description = $request->description;
            $item->update();

            AdminHelper::logPut('Updated cms info icons', MasterManageInfoIconModel::class, $item->id);

            return redirect()->route('admin.cms.manage-info-icon.index')
                ->with('success', 'Info Icon updated successfully.');
        }

        return redirect()->route('admin.cms.manage-info-icon.index')
            ->with('error', 'Item not found');
    }

    public function destroy(string $id)
    {
        // $item = MasterManageInfoIconModel::find($id);

        // if ($item) {

        //     $item->update();

        //     AdminHelper::logPut('Deleted cms info icons', MasterManageInfoIconModel::class, $item->id);

        //     return redirect()->route('admin.cms.manage-info-icon.index')
        //         ->with('success', 'Info Icon deleted successfully.');
        // }

        // return redirect()->route('admin.cms.manage-info-icon.index')
        //     ->with('error', 'Item not found');
    }
}
