<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterProjectsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        setPageTitle('Masters Project');
        $data['list'] = MasterProjectsModel::where('is_deleted',0)->orderby('id', 'desc')->get();
        addVendors(['datatables']);
        return view('admin.pages.master.project')->with($data);
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
        $validation = Validator::make($request->all(), [
            'project_name' => [
                'required',
                'max:255',
                'string',
                Rule::unique((new MasterProjectsModel)->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0');
                }),
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.master.project.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $project = MasterProjectsModel::create([
            'project_name' => $request->project_name,
        ]);

        AdminHelper::logPut('Created Project master', MasterProjectsModel::class, $project->id);

        return redirect()->route('admin.master.project.index')
            ->with('success', 'Project created successfully.');
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
    public function edit(string $id)
    {
        $item = MasterProjectsModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Masters Project');
            $data = [];
            $data['item'] = $item;
            $data['list'] = MasterProjectsModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('datatables');
            return view('admin.pages.master.project')->with($data);
        }

        return redirect()->route('admin.master.project.index')
            ->with('error', 'Item not found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = MasterProjectsModel::where('is_deleted', '0')->find($id);
        if ($item) {
            $validation = Validator::make($request->all(), [
                'project_name' => [
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

            $item->project_name = $request->project_name;
            $item->update();

            AdminHelper::logPut('Updated Project master', MasterProjectsModel::class, $item->id);

            return redirect()->route('admin.master.project.index')
                ->with('success', 'Project updated successfully.');
        }

        return redirect()->route('admin.master.project.index')
            ->with('error', 'Item not found');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = MasterProjectsModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $item->is_deleted = '1';
            $item->update();

            AdminHelper::logPut('Deleted Project master', MasterProjectsModel::class, $item->id);

            return redirect()->route('admin.master.project.index')
                ->with('success', 'Project deleted successfully.');
        }

        return redirect()->route('admin.master.project.index')
            ->with('error', 'Item not found');
    }
}
