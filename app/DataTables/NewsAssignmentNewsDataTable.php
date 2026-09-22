<?php

namespace App\DataTables;

use App\Helpers\FileUpDownHelper;
use App\Models\CompanyNewsModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NewsAssignmentNewsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($news) {
                return '<div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input news_checkbox" type="checkbox" value="' . $news->id . '" /></div>';
            })
            ->addColumn('image', function ($news) {
                if ($news->image) {
                    $url = url($news->image); // Assuming standard path, adjust if using FileUpDownHelper
                    return '<img src="' . $url . '" width="50" style="object-fit:cover;">';
                }
                return '-';
            })
            ->addColumn('link', function ($news) {
                if ($news->link) {
                    return '<a href="' . $news->link . '" target="_blank">View Link</a>';
                }
                return '-';
            })
            ->addColumn('action', function ($news) {
                return view('admin.pages.newsAssignment.partials.news-actions', compact('news'))->render();
            })
            ->rawColumns(['checkbox', 'image', 'link', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(CompanyNewsModel $model): QueryBuilder
    {
        return $model->where('company_id', $this->company_id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('news_assignment_news_table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" .
                "<'row'<'col-sm-12'tr>>" .
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>")
            ->orderBy(0, 'asc')
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
            Column::make('checkbox')
                ->title('<div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" id="check_all" /></div>')
                ->orderable(false)
                ->searchable(false)
                ->width(30)
                ->addClass('text-center'),
            Column::make('id')
                ->title('Sr No')
                ->searchable(true),
            Column::make('image')
                ->title('Image')
                ->orderable(false)
                ->searchable(false),
            Column::make('title')
                ->title('Title')
                ->searchable(true),
            Column::make('description')
                ->title('Description')
                ->searchable(true),
            Column::make('link')
                ->title('Link')
                ->searchable(true),
            Column::computed('action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'NewsAssignmentNews_' . date('YmdHis');
    }
}
