<?php

namespace App\Http\Controllers\Web\Admin\Startup;

use App\Helpers\AdminHelper;
use App\Helpers\DateTimeHelper;
use App\Http\Controllers\Controller;
use App\Models\StartupModel;
use App\Models\StartupPitchModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LivepitchController extends Controller
{
    public function index()
    {
        setPageTitle('Live Pitch');
        $data['list'] = StartupPitchModel::where('is_deleted', '0')->get();
        addVendor('datatables');
        return view('admin.pages.live_pitch.list')->with($data);
    }

    public function create()
    {
        setPageTitle('Create Live Pitch');
        $data['startups'] = StartupModel::where('is_deleted', '0')->orderby('brand_name', 'asc')->select('brand_name', 'id')->get();
        return view('admin.pages.live_pitch.create')->with($data);
    }

    public function store(Request $request)
    {
        $formattedDate = DateTimeHelper::formatDateTime($request->scheduled_date, 'd-m-Y h:i A');
        $request->merge(['scheduled_date' => $formattedDate]);
        $validation = Validator::make($request->all(), [
            'startup_id'  => 'required',
            'title'       => 'required',
            'description' => 'nullable',
            'scheduled_date' => 'required|date_format:d-m-Y h:i A',
            'host_url'        => 'required',
            'video_url'        => 'nullable',
        ], [
            'startup_id.required' => 'Startup is required.',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withInput()
                ->with('error', $validation->errors()->first());
        }
        $livePitch = new StartupPitchModel();

        $livePitch->startup_id = $request->startup_id;
        $livePitch->title = $request->title;
        $livePitch->description = $request->description;
        $livePitch->scheduled_date = DateTimeHelper::formatDateTime($request->scheduled_date, 'Y-m-d H:i:s');
        $livePitch->host_url = $request->host_url;
        $livePitch->user_url = $request->host_url;
        $livePitch->video_url = $request->video_url;
        $livePitch->save();

        AdminHelper::logPut('Created startup Live Pitch', StartupPitchModel::class, $livePitch->id);

        return redirect()->route('admin.startup.livepitch.index')
            ->with('success', 'Live Pitch created successfully.');
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $uuid)
    {
        $item = StartupPitchModel::where('uuid', $uuid)->where('is_deleted', '0')->first();
        if ($item) {
            setPageTitle('Edit Live Pitch');
            $data['item'] = $item;
            $data['startups'] = StartupModel::where('is_deleted', '0')->orderby('brand_name', 'asc')->select('brand_name', 'id')->get();
            $data['list'] = StartupPitchModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('tinymce');
            return view('admin.pages.live_pitch.edit')->with($data);
        }

        return redirect()->route('admin.startup.livepitch.index')
            ->with('error', 'Item not found');
    }


    public function update(Request $request, string $uuid)
    {
        $formattedDate = DateTimeHelper::formatDateTime($request->scheduled_date, 'd-m-Y h:i A');
        $request->merge(['scheduled_date' => $formattedDate]);
        $item = StartupPitchModel::where('uuid', $uuid)->where('is_deleted', '0')->first();
        if ($item) {

            $validation = Validator::make($request->all(), [
                'startup_id'  => 'required',
                'title'       => 'required',
                'description' => 'nullable',
                'scheduled_date' => 'required|date_format:d-m-Y h:i A',
                'host_url'        => 'required',
            ], [
                'startup_id.required' => 'Startup is required.',
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withInput()
                    ->with('error', $validation->errors()->first());
            }

            $item->startup_id = $request->startup_id;
            $item->title = $request->title;
            $item->description = $request->description;
            $item->scheduled_date = DateTimeHelper::formatDateTime($request->scheduled_date, 'Y-m-d H:i:s');
            $item->host_url = $request->host_url;
            $item->user_url = $request->host_url;
            $item->video_url = $request->video_url;
            $item->update();
            AdminHelper::logPut('Updated startup Live Pitch', StartupPitchModel::class, $item->id);

            return redirect()->route('admin.startup.livepitch.index')
                ->with('success', 'Live Pitch updated successfully.');
        }

        return redirect()->route('admin.startup.livepitch.index')
            ->with('error', 'Item not found');
    }


    public function destroy(string $uuid)
    {
        $item = StartupPitchModel::where('uuid', $uuid)->where('is_deleted', '0')->first();

        if ($item) {
            $item->is_deleted = '1';
            $item->update();

            AdminHelper::logPut('Deleted startup Live Pitch', StartupPitchModel::class, $item->id);

            return redirect()->route('admin.startup.livepitch.index')
                ->with('success', 'Live Pitch deleted successfully.');
        }

        return redirect()->route('admin.startup.livepitch.index')
            ->with('error', 'Item not found');
    }
}
