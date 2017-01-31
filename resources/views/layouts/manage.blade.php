@extends('layouts.single_portlet')

@section('title')
    Quản lý @yield('manage.name')
@endsection

@section('menu.manage', 'active')

@section('page_level_plugins.styles')
    @parent
    {!! Html::style('metronic/global/plugins/datatables/datatables.min.css') !!}
    {!! Html::style('metronic/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') !!}
@endsection

@section('styles')
    @parent
    {!! Html::style('css/manage.css') !!}
@endsection

@section('portlet-body')
    <div class="table-toolbar">
        <div class="row">
            <div class="col-md-6">
                <div class="btn-group">
                    <a class="btn sbold btn-primary" href="@yield('create_route', 'javascript:')">
                        Thêm mới
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-striped table-bordered table-hover table-checkable order-column"
           id="manage-table">
        <thead>
        @if(isset($thead_map))
            <tr>
                @foreach($thead_map as $td)
                    <td>{{$td['name']}}</td>
                @endforeach
            </tr>
        @endif
        </thead>
    </table>
@endsection

@section('page_level_plugins.scripts')
    @parent
    {!! Html::script('metronic/global/scripts/datatable.js') !!}
    {!! Html::script('metronic/global/plugins/datatables/datatables.min.js') !!}
    {!! Html::script('metronic/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') !!}
@endsection

@section('page_level_scripts')
    @parent
    {!! Html::script('metronic/pages/scripts/table-datatables-managed.min.js') !!}
@endsection

@section('scripts')
    @parent
    <script>
        var API_DATATABLE = '@yield('manage.api-datatable')';
    </script>

    @if(isset($thead_map))
        <script>
            var COLUMNS = [
                    @foreach($thead_map as $td)
                {
                    data: '{{$td['data']}}'
                },
                @endforeach
            ];
        </script>
    @endif

    {!! Html::script('js/manage.js') !!}
@endsection