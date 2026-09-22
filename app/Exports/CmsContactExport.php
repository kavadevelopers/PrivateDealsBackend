<?php

namespace App\Exports;

use App\Models\CmsContactModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CmsContactExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $contacts = CmsContactModel::orderBy('id', 'desc')->get();

        return view('admin.pages.reports.contact.export-excel', [
            'contacts' => $contacts,
        ]);
    }
}
