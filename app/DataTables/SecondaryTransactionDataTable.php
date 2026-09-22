<?php

namespace App\DataTables;

use App\Models\SecondaryTransaction;
use App\Models\SecondaryTransactionModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SecondaryTransactionDataTable extends DataTable
{
    protected $status;
    protected $operator = '=';

    public function withStatus($operator, $status)
    {   
        $this->operator = $operator;
        $this->status = $status;
        return $this;
    }
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('investor', function ($transaction) {
                return $transaction->buyer->name ?? 'N/A';
            })
            ->addColumn('seller', function ($transaction) {
                return $transaction->seller->name ?? 'N/A';
            })
            ->addColumn('startup', function ($transaction) {
                return $transaction->startup->brand_name ?? 'N/A';
            })
            ->addColumn('instrument', function ($transaction) {
                return $transaction->instrument;
            })
            ->addColumn('shares', function ($transaction) {
                return number_format($transaction->shares);
            })
            ->addColumn('investment', function ($transaction) {
                return number_format($transaction->investment_amount, 2);
            })
            ->addColumn('status', function ($transaction) {
                return $transaction->status == 8 ? 'Completed' : 'Pending';
            })
            ->addColumn('action', function ($transaction) {
                return view('admin.pages.transaction.secondary.partials.actions', compact('transaction'))->render();
            })
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SecondaryTransactionModel $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['buyer', 'seller', 'startup'])
            ->when(isset($this->status), function ($query) {
                return $query->where('status', $this->operator, $this->status);
            });
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('secondary_transactions_table')
            ->columns($this->getColumns())
            ->minifiedAjax()
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
            Column::make('investor')->title('Investor')->searchable(true),
            Column::make('seller')->title('Seller')->searchable(true),
            Column::make('startup')->title('Startup')->searchable(true),
            Column::make('instrument')->title('Instrument')->searchable(true),
            Column::make('shares')->title('Shares')->searchable(true),
            Column::make('investment')->title('Investment')->searchable(true),
            Column::make('status')->title('Status'),
            Column::computed('action')->title('Action')->exportable(false)->printable(false)->width(60)->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SecondaryTransaction_' . date('YmdHis');
    }
}
