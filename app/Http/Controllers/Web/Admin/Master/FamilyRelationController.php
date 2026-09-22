<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterFamilyRelationsModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FamilyRelationController extends Controller
{
    public function index(): View
    {
        setPageTitle('Family Relation');
        $data['familyrelationList'] = MasterFamilyRelationsModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        addVendor('datatables');
        return view('admin.pages.master.family_relation')->with($data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request): RedirectResponse
    {
        $familyrelation = new MasterFamilyRelationsModel();
        $validation = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique($familyrelation->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0');
                }),
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.master.family-relation.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $familyrelation->name = $request->name;
        $familyrelation->save();

        AdminHelper::logPut('Created master family relation', MasterFamilyRelationsModel::class, $familyrelation->id);

        return redirect()->route('admin.master.family-relation.index')
            ->with('success', 'Family Relation created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id): View
    {
        $item = MasterFamilyRelationsModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Masters Family Relation');
            $data['item'] = $item;
            $data['familyrelationList'] = MasterFamilyRelationsModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('datatables');
            return view('admin.pages.master.family_relation')->with($data);
        }

        return redirect()->route('admin.master.family-relation.index')
            ->with('error', 'Item not found');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $item = MasterFamilyRelationsModel::where('is_deleted', '0')->find($id);
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
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withInput()
                    ->with('error', $validation->errors()->first());
            }

            $item->name = $request->name;
            $item->update();

            AdminHelper::logPut('Updated master family relation', MasterFamilyRelationsModel::class, $item->id);

            return redirect()->route('admin.master.family-relation.index')
                ->with('success', 'Family Relation Updated Successfully.');
        }

        return redirect()->route('admin.master.family-relation.index')
            ->with('error', 'Item Not Found');
    }

    public function destroy(string $id): RedirectResponse
    {
        $item = MasterFamilyRelationsModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $item->is_deleted = '1';
            $item->update();

            AdminHelper::logPut('Deleted master family relation', MasterFamilyRelationsModel::class, $item->id);

            return redirect()->route('admin.master.family-relation.index')
                ->with('success', 'Family Relation deleted successfully.');
        }

        return redirect()->route('admin.master.family-relation.index')
            ->with('error', 'Item not found');
    }
}
