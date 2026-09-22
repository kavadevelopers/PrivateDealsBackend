<?php

namespace App\Http\Controllers\Web\Front\User\Startup;

use App\Enums\InstrumentTypeEnum;
use App\Enums\InvestorTypeEnum;
use App\Exports\CaptableTemplateDownload;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\StartupManageCaptableModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;

class ManageCaptableController extends Controller
{
    function list(): View
    {
        setPageTitle('Manage Captable');
        $data['list'] = StartupManageCaptableModel::orderby('holding_percentage', 'desc');
        return view('front.startup.managecaptable.list', $data);
    }

    function download()
    {
        $data = [];
        return Excel::download(new CaptableTemplateDownload($data), 'investor_data.xlsx');
    }

    function addShareHolder(): View
    {
        setPageTitle('Add Share Holder');
        return view('front.startup.managecaptable.create');
    }

    function saveManual(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'name'                         => 'required',
            'mobile_number'                => 'required|numeric|digits:10',
            'email'                        => 'required|email',
            'share'                        => 'required',
            'is_promoter'                  => 'required',
            'instrument_type'              => ['required', Rule::in(array_column(InstrumentTypeEnum::cases(), 'value'))],
            'investor_type'                => ['required', Rule::in(array_column(InvestorTypeEnum::cases(), 'value'))],
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->with('error', $validation->errors()->first());
        }
        $managecaptable = new StartupManageCaptableModel();
        $managecaptable->startup_id = Auth::guard('startup')->user()->id;
        $managecaptable->name  = $request->name;
        $managecaptable->email  = $request->email;
        $managecaptable->mobile_number  = $request->mobile_number;
        $managecaptable->share  = $request->share;
        $managecaptable->instrument_type = $request->instrument_type;
        $managecaptable->investor_type = $request->investor_type;
        $managecaptable->is_promoter = $request->is_promoter == 'yes' ? 1 : 0;
        $managecaptable->save();
        UtillsHelper::portfolioCreation($managecaptable);
        UtillsHelper::captableHoldingPercentageSet(Auth::guard('startup')->user()->id);
        return redirect()->route('front.raise.manageCaptable.list')->with('success', 'Shareholder created');
    }

    public function uploadExcel(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'file'               => 'required|file|mimes:xls,xlsx|max:' . UtillsHelper::maxFileDocumentSizeInKB()
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $array = Excel::toArray([], $request->file('file'));

        if (isset($array) && is_array($array) && count($array) > 0) {
            if (isset($array[0]) && is_array($array[0]) && count($array[0]) > 1) {
                $importData = array_slice($array[0], 0, 999);
                StartupManageCaptableModel::where('startup_id', Auth::guard('startup')->user()->id)->delete();
                foreach ($importData as $key => $row) {
                    if ($key != 0) {
                        if (
                            isset($row[0], $row[3], $row[4], $row[5], $row[6], $row[7]) &&
                            $row[0] !== null && $row[3] !== null && $row[4] !== null && $row[5] !== null && $row[6] !== null
                            && $row[7] !== null
                        ) {
                            if (is_numeric($row[3])) {
                                $item = new StartupManageCaptableModel();
                                $item->startup_id = Auth::guard('startup')->user()->id;
                                $item->name = $row[0];
                                $item->email = $row[1];
                                $item->mobile_number = $row[2];
                                $item->share = $row[3];
                                $item->holding_percentage = 0;
                                $item->instrument_type = $row[5];
                                $item->investor_type = $row[6];
                                $item->is_promoter = $row[7] == 'Yes' ? 1 : 0;
                                $item->save();

                                UtillsHelper::portfolioCreation($item);
                            }
                        }
                    }
                }

                UtillsHelper::captableHoldingPercentageSet(Auth::guard('startup')->user()->id);

                Session::flash('success', 'Data Imported');
                return UtillsHelper::json(1, ['message' => 'Data Imported']);
            }
        }
        return UtillsHelper::json(0, ['message' => 'Excel has no data']);
    }
}
