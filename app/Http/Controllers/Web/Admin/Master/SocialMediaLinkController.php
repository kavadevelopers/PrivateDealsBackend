<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterSocialmediaLinkModel;
use App\Models\MasterWebsiteSocialmediaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SocialMediaLinkController extends Controller
{
    public function index()
    {
        setPageTitle('Social Media');
        $data['socialmediaList'] = MasterSocialmediaLinkModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        addVendor('datatables');
        return view('admin.pages.master.social_media')->with($data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $socialmedia = new MasterSocialmediaLinkModel();
        $validation = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique($socialmedia->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0');
                }),
            ],
            'icon' => [
                'required',
                'max:255',
                'string',
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.master.social-media.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $socialmedia->name = $request->name;
        $socialmedia->icon = $request->icon;
        $socialmedia->save();

        AdminHelper::logPut('Created master social-media link', MasterSocialmediaLinkModel::class, $socialmedia->id);

        return redirect()->route('admin.master.social-media.index')
            ->with('success', 'Social Media created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $item = MasterSocialmediaLinkModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Social Media');
            $data['item'] = $item;
            $data['socialmediaList'] = MasterSocialmediaLinkModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('datatables');
            return view('admin.pages.master.social_media')->with($data);
        }

        return redirect()->route('admin.master.social-media.index')
            ->with('error', 'Item not found');
    }

    public function update(Request $request, string $id)
    {
        $item = MasterSocialmediaLinkModel::where('is_deleted', '0')->find($id);
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
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withInput()
                    ->with('error', $validation->errors()->first());
            }

            $item->name = $request->name;
            $item->icon = $request->icon;
            $item->update();

            AdminHelper::logPut('Updated master social-media link', MasterSocialmediaLinkModel::class, $item->id);

            return redirect()->route('admin.master.social-media.index')
                ->with('success', 'Social Media Updated Successfully.');
        }

        return redirect()->route('admin.master.social-media.index')
            ->with('error', 'Item Not Found');
    }

    public function destroy(string $id)
    {
        $item = MasterSocialmediaLinkModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $item->is_deleted = '1';
            $item->update();

            AdminHelper::logPut('Deleted master social-media link', MasterSocialmediaLinkModel::class, $item->id);

            return redirect()->route('admin.master.social-media.index')
                ->with('success', 'Social Media deleted successfully.');
        }

        return redirect()->route('admin.master.social-media.index')
            ->with('error', 'Item not found');
    }
}
