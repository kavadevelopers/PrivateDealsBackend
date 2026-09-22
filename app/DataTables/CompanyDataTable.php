<?php

namespace App\DataTables;

use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Models\Company;
use App\Models\CompanyModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CompanyDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('logo', function ($company) {
                return '<img src="' . FileUpDownHelper::get_company_logo_url($company) . '" width="50">';
            })
            ->addColumn('share_price', function ($company) {
                return UtillsHelper::rupee() . UtillsHelper::moneyFormatIndia($company->share_price);
            })
            ->addColumn('action', function ($company) {
                return view('admin.pages.company.partials.actions', compact('company'))->render();
            })
            ->addColumn('brand_name', function ($company) {
                $typeBadge = $company->type
                    ? '<span class="badge badge-light-primary">' . ucfirst($company->type) . '</span><br>'
                    : '';
                $approval = $company->approval_status ?? 'approved';
                $approvalBadge = $approval !== 'approved'
                    ? '<br><span class="badge badge-light-warning">' . ucfirst($approval) . '</span>'
                    : '';
                $brandName = $company->brand_name ?? '';
                $sectorBadge = $company->sector ? '<br><span class="badge badge-light-success">' . $company->sector->name . '</span>' : '';
                return $typeBadge . $brandName . $sectorBadge . $approvalBadge;
            })
            ->addColumn('category', function ($company) {
                $categoryText = $company->category ?? '';
                $trendingText = $company->is_trending ? '<br><span class="badge badge-light-info">Trending</span>' : '';
                return $categoryText . $trendingText;
            })
            ->filterColumn('share_price', function ($query, $keyword) {
                if (is_numeric(str_replace(',', '', $keyword))) {
                    $searchPrice = str_replace(',', '', $keyword);
                    $allCompanies = $query->with(['sharePrices' => function ($q) {
                        $q->orderBy('date', 'desc')
                            ->select('id', 'company_id', 'price', 'date');
                    }])->get();

                    $filteredIds = $allCompanies->filter(function ($company) use ($searchPrice) {
                        return str_contains(
                            (string) $company->share_price,
                            (string) $searchPrice
                        );
                    })->pluck('id')->toArray();

                    $query->whereIn('id', $filteredIds);
                }
            })
            ->filterColumn('category', function ($query, $keyword) {
                $query->where('category', 'like', '%' . $keyword . '%');
            })
            ->filterColumn('brand_name', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('brand_name', 'like', '%' . $keyword . '%')
                        ->orWhere('type', 'like', '%' . strtolower($keyword) . '%')
                        ->orWhereHas('sector', function ($sectorQuery) use ($keyword) {
                            $sectorQuery->where('name', 'like', '%' . $keyword . '%');
                        });
                });
            })
            ->rawColumns(['logo', 'action', 'category', 'brand_name'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(CompanyModel  $model): QueryBuilder
    {
        // return $model->select('id', 'uuid', 'logo', 'brand_name', 'company_name')
        //          ->where('is_deleted', '0')->orderBy('brand_name','asc');
        return $model->select('id', 'uuid', 'logo', 'brand_name', 'company_name', 'list_order', 'category', 'type', 'sector_id', 'is_trending', 'share_price', 'approval_status')
            ->with('sector:id,name') // Load sector relationship with only id and name
            ->where('is_deleted', '0')
            ->orderByRaw('list_order IS NULL') // Push NULL values to the end
            ->orderBy('list_order', 'asc')    // Then sort by list_order
            ->orderBy('brand_name', 'asc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('kt_datatable_dom_positioning')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" .
                "<'row'<'col-sm-12'tr>>" .
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>")
            ->orderBy(1)
            ->parameters([
                'drawCallback' => 'function() { KTMenu.createInstances(); }',
                'language' => [
                    'lengthMenu' => "Show _MENU_ records per page",
                    'zeroRecords' => "No matching records found",
                    'info' => "Showing _START_ to _END_ of _TOTAL_ entries",
                    'infoEmpty' => "No records available",
                    'infoFiltered' => "(filtered from _MAX_ total records)"
                ],
                'pageLength' => 10,
                'searching' => true
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('logo')
                ->title('Logo')
                ->orderable(false)
                ->searchable(false),
            Column::make('brand_name')
                ->title('Brand Name')
                ->searchable(true),
            Column::make('company_name')
                ->title('Company Name')
                ->searchable(true),
            Column::make('category')
                ->title('Category Name')
                ->searchable(true)
                ->addClass('text-center'),
            Column::make('share_price')
                ->title('Share Price')
                ->searchable(true),
            Column::computed('action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Company_' . date('YmdHis');
    }
}
