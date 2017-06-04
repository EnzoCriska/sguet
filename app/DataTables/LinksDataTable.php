<?php

namespace App\DataTables;

use Yajra\Datatables\Services\DataTable;

class LinksDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->collection($this->query())
            ->editColumn('url', function($link) {
                return \Html::link($link->url);
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        return collect([
            [
                'url' => 'https://ueter.xyz/',
                'description' => 'Hóng điểm thi UET tốc độ ánh sáng'
            ],
            [
                'url' => 'http://bluebee-uet.com/',
                'description' => 'Hệ thống tài liệu, đề thi các năm'
            ],
            [
                'url' => 'http://doit.uet.vnu.edu.vn/',
                'description' => 'Hệ thống hỗ trợ nâng cao chất lượng tài liệu',
            ],
            [
                'url' => 'https://112.137.129.87/',
                'description' => 'Cổng thông tin đào tạo'
            ],
            [
                'url' => 'http://student.uet.vnu.edu.vn/',
                'description' => 'Dịch vụ hỗ trợ gửi/nhận yêu cầu của Sinh viên',
            ]
        ])->map(function($array) {
            return (object)$array;
        });
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->ajax('')
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'url' => ['title' => 'Đường dẫn'],
            'description' => ['title' => 'Mô tả']
        ];
    }

    protected function getBuilderParameters()
    {
        return [
            'order' => [0, 'desc'],
        ];
    }
}
