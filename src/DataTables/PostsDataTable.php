<?php

namespace Squirrel\Blog\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Squirrel\Blog\Repositories\PostRepository;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Squirrel\Blog\Models\BlogPost;

class PostsDataTable extends DataTable
{
    protected $exportColumns = [
        ['data' => 'id', 'title' => 'id'],
        ['data' => 'name', 'title' => 'name'],
        ['data' => 'title', 'title' => 'title'],
        ['data' => 'slug', 'title' => 'slug'],
        ['data' => 'image', 'title' => 'image'],
        ['data' => 'excerpt', 'title' => 'excerpt'],
        ['data' => 'content', 'title' => 'content'],
        ['data' => 'owner_id', 'title' => 'owner_id'],
        ['data' => 'owner_id', 'title' => 'owner_id'],
        ['data' => 'created_at', 'title' => 'created_at']
    ];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('_id', 'Admin::datatable.formats.id')
            ->addColumn('image', 'Admin::datatable.formats.image')
            ->addColumn('created_at', 'Admin::datatable.formats.created_at')
            ->addColumn('action', function (BlogPost $model) {
                return view('Admin::datatable.action', [
                    'id' => $model->id,
                    'hide' => ['view'],
                    'preview' => $model->cast->url
                ]);
            })
            ->rawColumns(['_id', 'image', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param BlogPost $model
     * @return Builder
     */
    public function query(PostRepository $postRepo)
    {
        return $postRepo->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('blog-posts-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' .
                        '<"col-lg-12 col-xl-3"l>' .
                        '<"col-lg-12 col-xl-9 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap me-1"<"me-1"f>B>>' .
                        '>t' .
                        '<"d-flex justify-content-between mx-2 row mb-1"' .
                        '<"col-sm-12 col-md-6"i>' .
                        '<"col-sm-12 col-md-6"p>' .
                        '>')
                    ->buttons(
                        Button::make([
                            'extend' => 'create',
                            'className' => 'btn-primary',
                            'text' => __('Add New')
                        ]),
                        Button::make([
                            'extend' => 'reload',
                            'className' => 'btn-secondary',
                            'text' => __('Reload')
                        ])
                    )
                    ->language([
                        'emptyTable' => __('No data available in table'),
                        'info' => __('Showing _START_ to _END_ of _TOTAL_ entries'),
                        'infoEmpty' => __('Showing 0 to 0 of 0 entries'),
                        'loadingRecords' => __('Loading...'),
                        'processing' => __('Processing...'),
                        'search' => __('Search:'),
                        'paginate' => [
                            'first' => __('First'),
                            'last' => __('Last'),
                            'next' => __('Next'),
                            'previous' => __('Previous'),
                        ],
                        'lengthMenu' => __('Show _MENU_ entries')
                    ])
            ;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')
                ->data('_id')
                ->title(__('ID')),
            Column::make('image')
                ->title(__('Image'))
                ->width(80),
            Column::make('name')
                ->title(__('Name')),
            Column::make('created_at')
                ->title(__('Created at')),
            Column::computed('action')
                ->title(__('Actions'))
                ->width(80)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Blog_posts_' . date('YmdHis');
    }
}
