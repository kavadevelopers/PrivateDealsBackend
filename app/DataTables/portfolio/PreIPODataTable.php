<?php

namespace App\DataTables\portfolio;

use App\Helpers\CommonHelper;
use App\Helpers\UtillsHelper;
use App\Models\PortfolioPreIpoModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;

class PreIPODataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('company_name', function ($row) {
                return $row->company->brand_name ?? '-';
            })
            ->addColumn('investor_name', function ($row) {
                return $row->investor->name ?? '-';
            })
            ->editColumn('shares', function ($row) {
                return (int) $row->shares;
            })
            ->editColumn('purchase_price', function ($row) {
                return UtillsHelper::rupee() . UtillsHelper::moneyFormatIndia($row->purchase_price);
            })
            ->editColumn('investment_amount', function ($row) {
                return UtillsHelper::rupee() . UtillsHelper::moneyFormatIndia($row->investment_amount);
            })
            ->editColumn('instrument', function ($row) {
                return ucfirst($row->instrument);
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PortfolioPreIpoModel $model): QueryBuilder
    {
        return $model->where('shares', '>', 0)->with(['company', 'investor']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $length = CommonHelper::appSettings('admin_panel_table_pagination_limit');
        return $this->builder()
            ->setTableId('portfolio-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'dom' => "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                'buttons' => ['excel', 'csv', 'print', 'reload'],
                'language' => [
                    'lengthMenu' => "Show _MENU_ records per page",
                    'zeroRecords' => "No matching records found",
                    'info' => "Showing _START_ to _END_ of _TOTAL_ entries",
                    'infoEmpty' => "No records available",
                    'infoFiltered' => "(filtered from _MAX_ total records)"
                ],
                'lengthMenu' => UtillsHelper::getDataTableLengthMenu(),
                'pageLength' => (int)$length,
                'columnDefs' => [
                    ['targets' => [2], 'className' => 'text-center'],
                    ['targets' => [3, 4], 'className' => 'text-end']
                ]
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            ['data' => 'company_name', 'name' => 'company.brand_name', 'title' => 'Company'],
            ['data' => 'investor_name', 'name' => 'investor.name', 'title' => 'Investor'],
            ['data' => 'shares', 'name' => 'shares', 'title' => 'Shares'],
            ['data' => 'purchase_price', 'name' => 'purchase_price', 'title' => 'Avg'],
            ['data' => 'investment_amount', 'name' => 'investment_amount', 'title' => 'Invested'],
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PreIpo_Portfolio' . date('YmdHis');
    }
}
