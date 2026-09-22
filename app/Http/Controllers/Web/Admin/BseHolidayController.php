<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\HolidayTypeEnum;
use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\BseHolidayModel;
use App\Helpers\BseCalendarHelper;
use App\Helpers\CommonHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Traits\FileUploadTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class BseHolidayController extends Controller
{
    use FileUploadTrait;

    public function index(): View
    {
        setPageTitle('Holidays Management');
        $data['list'] = BseHolidayModel::where('is_deleted', '0')->orderBy('holiday_date', 'desc')->get();
        addVendor('datatables');
        return view('admin.pages.bse-holiday.list')->with($data);
    }

    /**
     * Get holidays list for DataTable
     */
    public function list(): JsonResponse
    {
        setPageTitle('Holidays Management');
        $query = BseHolidayModel::where('is_deleted', '0');

        // Search - FIXED: Wrapped in closure to avoid SQL issues
        if (request()->has('search') && request('search')['value']) {
            $search = request('search')['value'];
            $query->where(function ($q) use ($search) {
                $q->where('holiday_name', 'like', "%{$search}%")
                    ->orWhere('holiday_date', 'like', "%{$search}%")
                    ->orWhere('holiday_type', 'like', "%{$search}%");
            });
        }

        // Order
        $orderColumn = request('order')[0]['column'] ?? 0;
        $orderDir = request('order')[0]['dir'] ?? 'asc';

        $columns = ['holiday_date', 'holiday_name', 'holiday_type', 'is_active'];
        if (isset($columns[$orderColumn])) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('holiday_date', 'desc');
        }

        $total = BseHolidayModel::where('is_deleted', '0')->count();
        $filtered = $query->count();

        $holidays = $query->offset(request('start', 0))
            ->limit(request('length', 10))
            ->get()
            ->map(function ($holiday) {
                return [
                    'holiday_img' => '<div class="symbol symbol-50px me-5">
                        <img class="shimmer lazy" data-src="' . FileUpDownHelper::get_holiday_img_url($holiday) . '" />
                    </div>',
                    'holiday_date' => $holiday->holiday_date->format('M d, Y'),
                    'holiday_name' => $holiday->holiday_name,
                    'holiday_type' => '<span class="badge badge-light-info">' . str_replace('_', ' ', ucwords($holiday->holiday_type, '_')) . '</span>',
                    'is_active' => $holiday->is_active
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-danger">Inactive</span>',
                    'action' => '
                        <a href="' . route('admin.bse-holiday.edit', ['uuid' => $holiday->uuid]) . '" class="btn btn-primary hover-elevate-up btn-icon btn-sm me-1" title="Edit">
                            <i class="fas fa-pencil fs-6"></i>
                        </a>
                        <form action="' . route('admin.bse-holiday.delete', ['uuid' => $holiday->uuid]) . '" method="POST" style="display:inline;" id="delete-form-' . $holiday->id . '" onsubmit="return confirm(\'Are you sure you want to delete this holiday?\');">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger hover-elevate-up btn-icon btn-sm me-1" title="Delete">
                                <i class="fas fa-trash fs-6"></i>
                            </button>
                        </form>
                    '
                ];
            });

        return response()->json([
            'draw' => intval(request('draw', 1)),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $holidays,
        ]);
    }


    /**
     * Show the form for creating a new holiday
     */
    public function create(): View
    {
        setPageTitle('Create Holiday');
        return view('admin.pages.bse-holiday.create');
    }

    /**
     * Store a newly created holiday in storage
     */
    public function store(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'holiday_date' => 'required|date|unique:bse_holidays,holiday_date',
            'holiday_name' => 'required',
            'title' => 'nullable|string|max:255',
            'holiday_type' => 'required|in:' . implode(',', array_column(HolidayTypeEnum::cases(), 'value')),
            'is_active' => 'boolean',
            'holiday_img' => 'required|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
            'notes' => 'nullable',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()
                ->with('error', $validation->errors()->first());
        }

        // $holiday = BseHolidayModel::create($request->all());

        $holiday = new BseHolidayModel();
        $holiday->holiday_date = $request->holiday_date;
        $holiday->holiday_name = $request->holiday_name;
        $holiday->title = $request->title;
        $holiday->holiday_type = $request->holiday_type;
        $holiday->is_active = $request->is_active ?? true;
        $holiday->notes = $request->notes;

        if ($request->hasFile('holiday_img')) {
            $holiday->holiday_img = FileUpDownHelper::master_holiday_img_upload($request->file('holiday_img'));
        }
        $holiday->save();

        BseCalendarHelper::invalidateCache();

        AdminHelper::logPut('Created BSE Holiday', BseHolidayModel::class, $holiday->id);

        return redirect()->route('admin.bse-holiday.index')
            ->with('success', 'Holiday added successfully.');
    }

    /**
     * Show the form for editing the specified holiday
     */
    public function edit(string $uuid): View|RedirectResponse
    {
        $item = BseHolidayModel::where('uuid', $uuid)->where('is_deleted', '0')->first();

        if ($item) {
            setPageTitle('Edit Holiday');
            $data['item'] = $item;
            return view('admin.pages.bse-holiday.edit')->with($data);
        }

        return redirect()->route('admin.bse-holiday.index')
            ->with('error', 'Holiday not found');
    }

    /**
     * Update the specified holiday in storage
     */
    public function update(Request $request, string $uuid): RedirectResponse
    {
        $item = BseHolidayModel::where('uuid', $uuid)->where('is_deleted', '0')->first();

        if ($item) {
            $validation = Validator::make($request->all(), [
                'holiday_date' => 'required|date|unique:bse_holidays,holiday_date,' . $item->id,
                'holiday_name' => 'required',
                'title' => 'nullable|string|max:255',
                'holiday_type' => 'required|in:' . implode(',', array_column(HolidayTypeEnum::cases(), 'value')),
                'is_active' => 'boolean',
                'notes' => 'nullable',
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withInput()
                    ->with('error', $validation->errors()->first());
            }


            $item->holiday_date = $request->holiday_date;
            $item->holiday_name = $request->holiday_name;
            $item->title = $request->title;
            $item->holiday_type = $request->holiday_type;
            $item->is_active = $request->is_active ?? true;
            $item->notes = $request->notes;

            if ($request->hasFile('holiday_img')) {
                $this->deleteFile($item->holiday_img);
                $item->holiday_img = FileUpDownHelper::master_holiday_img_upload($request->file('holiday_img'));
            }

            $item->update();
            // Invalidate cache
            BseCalendarHelper::invalidateCache();

            AdminHelper::logPut('Updated BSE Holiday', BseHolidayModel::class, $item->id);

            return redirect()->route('admin.bse-holiday.index')
                ->with('success', 'Holiday updated successfully.');
        }

        return redirect()->route('admin.bse-holiday.index')
            ->with('error', 'Holiday not found');
    }

    /**
     * Delete the specified holiday
     */
    public function destroy(string $uuid): RedirectResponse
    {
        $item = BseHolidayModel::where('uuid', $uuid)->where('is_deleted', '0')->first();

        if ($item) {
            $item->is_deleted = '1';
            $item->update();

            // Invalidate cache
            BseCalendarHelper::invalidateCache();

            AdminHelper::logPut('Deleted BSE Holiday', BseHolidayModel::class, $item->id);

            return redirect()->route('admin.bse-holiday.index')
                ->with('success', 'Holiday deleted successfully.');
        }

        return redirect()->route('admin.bse-holiday.index')
            ->with('error', 'Holiday not found');
    }

    /**
     * Toggle active status of a holiday
     */
    public function toggleActive(string $uuid): RedirectResponse
    {
        $item = BseHolidayModel::where('uuid', $uuid)->where('is_deleted', '0')->first();

        if ($item) {
            $item->update(['is_active' => !$item->is_active]);

            // Invalidate cache
            BseCalendarHelper::invalidateCache();

            $status = $item->is_active ? 'activated' : 'deactivated';

            AdminHelper::logPut("Holiday {$status}", BseHolidayModel::class, $item->id);

            return redirect()->route('admin.bse-holiday.index')
                ->with('success', "Holiday {$status} successfully.");
        }

        return redirect()->route('admin.bse-holiday.index')
            ->with('error', 'Holiday not found');
    }

    /**
     * Get holidays for a specific year (for AJAX requests)
     */
    public function getHolidaysByYear(Request $request): \Illuminate\Http\JsonResponse
    {
        $year = $request->query('year', now()->year);

        $holidays = BseHolidayModel::where('is_deleted', '0')
            ->where('is_active', true)
            ->whereYear('holiday_date', $year)
            ->orderBy('holiday_date')
            ->get();

        return response()->json([
            'success' => true,
            'year' => $year,
            'total' => $holidays->count(),
            'holidays' => $holidays,
        ]);
    }

    /**
     * Bulk import holidays from array
     */
    public function bulkImport(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'holidays' => 'required|json',
        ]);

        try {
            $holidays = json_decode($validated['holidays'], true);

            foreach ($holidays as $holiday) {
                BseHolidayModel::firstOrCreate(
                    ['holiday_date' => $holiday['date']],
                    [
                        'holiday_name' => $holiday['name'],
                        'holiday_type' => $holiday['type'] ?? 'market_closure',
                        'is_active' => true,
                        'is_deleted' => false,
                        'notes' => $holiday['notes'] ?? null,
                    ]
                );
            }

            // Invalidate cache
            BseCalendarHelper::invalidateCache();

            return redirect()->route('admin.bse-holiday.index')
                ->with('success', 'Holidays imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.bse-holiday.index')
                ->with('error', 'Error importing holidays: ' . $e->getMessage());
        }
    }
}
