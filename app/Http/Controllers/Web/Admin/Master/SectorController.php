<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Helpers\CommonHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterIndustryModel;
use App\Models\MasterSectorsModel;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SectorController extends Controller
{

    use FileUploadTrait; 

    public function index()
    {
        setPageTitle('Masters Sector');
        $data['list'] = MasterSectorsModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        $data['industry'] = MasterIndustryModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        addVendors(['datatables', 'lazy-image']);
        return view('admin.pages.master.sector')->with($data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $sector = new MasterSectorsModel();
        $validation = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique($sector->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0');
                }),
            ],
            'industry_id' => 'required',
            'image' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
            'display_order' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.master.sector.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $sector->name = $request->name;
        $sector->industry_id = $request->industry_id;
        $sector->display_order = $request->display_order;
        $sector->url_slug = AdminHelper::sectorSlug(strtolower($request->name));
        if ($request->hasFile('image')) {
            $sector->icon_image = FileUpDownHelper::master_sector_image_upload($request->file('image'));
        }
        $sector->save();

        AdminHelper::logPut('Created sector master', MasterSectorsModel::class, $sector->id);

        return redirect()->route('admin.master.sector.index')
            ->with('success', 'Sector created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $item = MasterSectorsModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Masters Sector');
            $data['item'] = $item;
            $data['list'] = MasterSectorsModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            $data['industry'] = MasterIndustryModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('datatables');
            return view('admin.pages.master.sector')->with($data);
        }

        return redirect()->route('admin.master.sector.index')
            ->with('error', 'Item not found');
    }

    public function update(Request $request, string $id)
    {
        $item = MasterSectorsModel::where('is_deleted', '0')->find($id);
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
                'industry_id' => 'required',
                'image' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
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
            $item->industry_id = $request->industry_id;
            $item->url_slug = AdminHelper::sectorSlug(strtolower($request->name));
            if ($request->hasFile('image')) {
                $file = FileUpDownHelper::master_sector_image_upload($request->file('image'));
                if ($file) {
                    $this->deleteFile($item->icon_image);
                    $item->icon_image = $file;
                }
            }
            $item->display_order = $request->display_order;
            $item->update();

            AdminHelper::logPut('Updated sector master', MasterSectorsModel::class, $item->id);

            return redirect()->route('admin.master.sector.index')
                ->with('success', 'Sector updated successfully.');
        }

        return redirect()->route('admin.master.sector.index')
            ->with('error', 'Item not found');
    }

    public function destroy(string $id)
    {
        $item = MasterSectorsModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $item->is_deleted = '1';
            $item->update();
            $this->deleteFile($item->icon_image);

            AdminHelper::logPut('Deleted sector master', MasterSectorsModel::class, $item->id);

            return redirect()->route('admin.master.sector.index')
                ->with('success', 'Sector deleted successfully.');
        }

        return redirect()->route('admin.master.sector.index')
            ->with('error', 'Item not found');
    }
}
