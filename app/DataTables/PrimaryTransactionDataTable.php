<?php

namespace App\DataTables;

use App\Models\PrimaryTransaction;
use App\Models\PrimaryTransactionModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PrimaryTransactionDataTable extends DataTable
{
    protected $status;
    protected $operator = '=';
    public function withStatus($operator,$status)
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
                return $transaction->investor->name ?? 'N/A';
            })
            ->addColumn('startup', function ($transaction) {
                $startupName = $transaction->startup->brand_name ?? 'N/A';
                $roundName = $transaction->round->name ?? 'N/A';
                return "{$startupName} <br> {$roundName}";
            })
            ->addColumn('instrument', function ($transaction) {
                return $transaction->instrument;
            })
            ->addColumn('investment', function ($transaction) {
                return number_format($transaction->investment_amount, 2);
            })
            ->addColumn('share_price', function ($transaction) {
                return number_format($transaction->share_price, 2);
            })
            ->addColumn('shares', function ($transaction) {
                return number_format($transaction->shares);
            })
            ->addColumn('date', function ($transaction) {
                return $transaction->created_at ? $transaction->created_at->timestamp : null;
            })
            ->editColumn('date_formatted', function ($transaction) {
                return $transaction->created_at ? $transaction->created_at->format('Y-m-d') : null;
            })
            ->addColumn('action', function ($transaction) {
                return view('admin.pages.transaction.partials.actions', compact('transaction'))->render();
            })
            ->filterColumn('investor', function($query, $keyword) {
                $query->whereHas('investor', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('startup', function($query, $keyword) {
                $query->whereHas('startup', function ($q) use ($keyword) {
                    $q->where('brand_name', 'like', "%{$keyword}%");
                })->orWhereHas('round', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('instrument', function($query, $keyword) {
                $query->where('instrument', 'like', "%{$keyword}%");
            })
            ->filterColumn('investment', function($query, $keyword) {
                $searchAmount = str_replace(',', '', $keyword);
                $query->whereRaw("CAST(investment_amount AS DECIMAL(10,2)) LIKE ?", ["%$searchAmount%"]);
            })
            ->filterColumn('share_price', function($query, $keyword) {
                $searchPrice = str_replace(',', '', $keyword);
                $query->whereRaw("CAST(share_price AS DECIMAL(10,2)) LIKE ?", ["%$searchPrice%"]);
            })
            ->filterColumn('shares', function($query, $keyword) {
                $query->where('shares', 'like', "%{$keyword}%");
            })
            ->rawColumns(['status', 'action','startup'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PrimaryTransactionModel $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['investor', 'startup', 'round'])
            ->when(isset($this->status), function ($query) {
                return $query->where('status', $this->operator, $this->status);
            })
            ->when(request()->has('investor_key'), function ($query) {
                
                return $query->whereHas('investor', function ($q) {
                    $q->where('uuid', request()->get('investor_key'));
                });
            })
            ->orderBy('created_at', 'desc');
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
            ->orderBy(6, 'desc')
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
            Column::make('startup')->title('Startup & Round')->searchable(true),
            // Column::make('round')->title('Round')->searchable(true),
            Column::make('instrument')->title('Instrument')->searchable(true),
            Column::make('investment')->title('Investment')->searchable(true),
            Column::make('share_price')->title('Share Price')->searchable(true),
            Column::make('shares')->title('Shares')->searchable(true),
            Column::make('date')->title('Date')
                ->searchable(true)
                ->orderable(true)
                ->data('date_formatted'), 
            Column::computed('action')->title('Action')->exportable(false)->printable(false)->width(60)->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PrimaryTransaction_' . date('YmdHis');
    }
}
