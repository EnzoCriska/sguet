@extends('layouts.manage')

@section('manage.name', 'Tin tức - Hoạt động')

@section('menu.manage.article', 'active')

@section('create_route', route('manage.article.create'))

@section('thead')

    <tr>
        <td>ID</td>
        <td>Tiêu đề</td>
        <td>Mô tả</td>
        <td>Loại</td>
        <td>Thời gian tạo</td>
        <td>Cập nhật lần cuối</td>
        {{--<td>Quản lý</td>--}}
    </tr>
@endsection

@section('scripts')
    <script>
        var COLUMNS = [
            {data: 'id', name: 'articles.id'},
            {data: 'title', name: 'articles.title'},
            {data: 'short_description', name: 'articles.short_description'},
            {data: 'name', name: 'categories.name'},
            {data: 'created_at', name: 'articles.created_at'},
            {data: 'updated_at', name: 'articles.updated_at'}
//            {data: 'action', orderable: false, searchable: false}
        ]
    </script>
    @parent
@endsection