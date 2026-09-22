<?php

namespace App\Http\Controllers\Web\Admin\Setting;

use App\Helpers\AdminHelper;
use App\Helpers\FileUpDownHelper;
use App\Http\Controllers\Controller;
use App\Models\AppBuildModel;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AppBuildController extends Controller
{
    public function create(): View
    {
        setPageTitle('Upload App Build');
        return view('admin.pages.appbuild.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'version' => 'nullable|string',
            'build'   => 'required|file|max:512000'
        ]);

        if ($request->hasFile('build')) {
            $ext = strtolower($request->file('build')->getClientOriginalExtension());
            if (!in_array($ext, ['apk', 'aab', 'ipa'])) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Only APK, AAB, or IPA files are allowed.');
            }
        }

        if ($validation->fails()) {
            return redirect()->back()
                ->withInput()
                ->with('error', $validation->errors()->first());
        }

        DB::beginTransaction();

        try {

            $build = new AppBuildModel();

            if ($request->hasFile('build')) {
                $build->file = FileUpDownHelper::app_build_upload($request->file('build'));
            }

            $build->version = $request->version;
            $build->save();

            AdminHelper::logPut('Uploaded App Build', AppBuildModel::class, $build->id);

            DB::commit();

            $bucketUrl = FileUpDownHelper::get_app_build_url($build->file);

            return redirect()->route('admin.systemConfiguration.appbuild.list')
                ->with('success', 'Build uploaded successfully')
                ->with('download_link', $bucketUrl);
        } catch (Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    public function list(): View
    {
        setPageTitle('App Build List');
        addVendor('datatables');

        $data['list'] = AppBuildModel::latest()->get();

        return view('admin.pages.appbuild.list', $data);
    }

    public function download(string $uuid)
    {
        $build = AppBuildModel::where('uuid', $uuid)->firstOrFail();

        $url = FileUpDownHelper::get_app_build_url($build->file);
        $filename = basename($build->file);

        $headers = [
            'Content-Type'        => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function () use ($url) {
            $stream = fopen($url, 'r');
            fpassthru($stream);
            fclose($stream);
        }, 200, $headers);
    }

    public function delete($id): RedirectResponse
    {
        $item = AppBuildModel::where('id', $id)->first();

        if ($item) {
            AdminHelper::logPut('App build deleted ' . $item->version, AppBuildModel::class, $item->id);
            $item->delete();
            return redirect()->back()->with('success', 'Build deleted successfully');
        }
        return redirect()->back()->with('error', 'Item not found');
    }
}
