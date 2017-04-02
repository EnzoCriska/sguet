@extends('layouts.single_portlet')

@if(isset($from_manage))
    @section('menu.manage', 'active')
    @section('menu.manage.contact', 'active')
@else
    @section('menu.contacts', 'active')
@endif

@section('title', 'Danh bạ Trường Đại học Công nghệ')

@section('page_level_plugins.styles')
    @parent
    {!! Html::style('metronic/global/plugins/jstree/dist/themes/default/style.min.css') !!}
    {!! Html::style('metronic/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') !!}
    {!! Html::style('css/jstreegrid.css') !!}
@endsection

@section('icon', 'fa fa-phone')

@section('portlet-body')
    <div class="table-toolbar">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet-input input-inline input-small">
                    <div class="input-icon right tooltips" data-container="body" data-placement="top" data-original-title="Enter để tìm kiếm" style="min-width: 300px">
                        <i class="icon-magnifier"></i>
                        <input type="text" class="form-control" placeholder="Nhập tên"
                               id="search"></div>
                </div>
                @if(Auth::check())
                    <div class="btn-group pull-right" id="manage">
                        <a class="btn btn-default " href="javascript:;" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-cog"></i> Quản lý
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="javascript:" id="upload">
                                    <i class="fa fa-upload"></i> Tải lên </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-download"></i> Tải xuống  </a>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div id="tree" class="jstree jstree-default"></div>
    @if(Auth::check())
        <div id="bootbox-content" hidden>
            {!! Form::open(['method' => 'post', 'route' => 'manage.contact.upload', 'class' => 'form', 'role' => 'form', 'enctype' =>"multipart/form-data"]) !!}
                <div class="form-body">
                    <div class="form-group">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="input-group input-large">
                                <div class="form-control uneditable-input input-fixed input-medium"
                                     data-trigger="fileinput">
                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                    <span class="fileinput-filename"> </span>
                                </div>
                                <span class="input-group-addon btn default btn-file">
                                        <span class="fileinput-new"> Chọn </span>
                                        <span class="fileinput-exists"> Đổi </span>
                                        <input type="file" name="file" required="required"
                                               accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                </span>
                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists"
                                   data-dismiss="fileinput"> Xoá </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions" style="background-color: transparent">
                    <button type="submit" class="btn blue">Tải lên</button>
                    <button type="button" class="bootbox-close-button btn default">Đóng</button>
                </div>
            {!! Form::close() !!}
        </div>
    @endif
@endsection

@section('page_level_plugins.scripts')
    @parent
    @if(isset($from_manage))
        {!! Html::script('metronic/global/plugins/jquery.pulsate.min.js') !!}
        <script async>
            Scroll('manage').toVisible();
            $('#manage').pulsate({
                color: "#399bc3",
                repeat: 3
            })
        </script>
    @endif
    {!! Html::script('metronic/global/plugins/jstree/dist/jstree.min.js') !!}
    {!! Html::script('js/jstreegrid.js') !!}
    {!! Html::script('metronic/global/plugins/bootbox/bootbox.min.js') !!}
    {!! Html::script('metronic/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') !!}
@endsection

@section('scripts')
    @parent
    <script>
        function onError(ex) {
            toastr['error']('Vui lòng tải lại trang', 'Đã có lỗi xảy ra');
            // $('html').html(ex.responseText);
        }

        $(document).ready(function () {
            var tree = $('#tree');
            var search = $('#search');

            tree.on('search.jstree', function (e, data) {
                if (data.nodes.length > 0) {
                    var first = data.nodes[0];
                    Scroll(first.id).toVisible();
                }
            }).jstree({
                plugins: ["grid"],
                grid: {
                    columns: [
                        {header: "Tên", width: "30%"},
                        {header: "Chức vụ", value: "description", width: "20%"},
                        {header: "CQ", value: "phone_cq", width: "10%"},
                        {header: "NR", value: "phone_nr", width: "10%"},
                        {header: "DĐ", value: "phone_dd", width: "10%"},
                        {header: "Fax", value: "fax", width: "10%"},
                        {header: "Email", value: "email", width: "10%"}
                    ]
                },
                core: {
                    strings: {
                        'Loading ...': 'Đang tải ...'
                    },
                    check_callback: true,
                    expand_selected_onload: true,
                    multiple: true,
                    force_text: true,
                    dblclick_toggle: true,
                    themes: {
                        variant: "large",
                        dots: true,
                        icons: false,
                        responsive: true
                    },
                    data: {
                        url: function (node) {
                            return node.id === '#' ? '{{route('api.contacts.roots')}}' : '{{route('api.contacts.children', '_ID_')}}'.replace('_ID_', node.id);
                        },
                        data: function (node) {
                            return '{{route('api.contacts.show', '_ID_')}}'.replace('_ID_', node.id);
                        }
                    }
                }
            });

            search.keyup(function (e) {
                const code = e.which | e.code;
                if (code === 13) {
                    doSearch(search.val());
                }
            });
        });

        function doSearch(q) {
            UI('portlet').block();
            var show_all = function(inst) {
                inst.show_all();
                $('.jstree-grid-cell').removeClass('jstree-hidden');
            };
            if (q.trim() === '') {
                const inst = $.jstree.reference(tree);
               show_all(inst);
                UI('portlet').unblock();
            } else {
                $.ajax({
                    url: "{{route('api.contacts.search')}}?q=" + q.trim(),
                    method: 'GET',
                    success: function (response) {
                        var inst = $.jstree.reference(tree);
                        var opened = response.opened;
                        var hidden = response.hidden;
                        var result = response.result;
                        console.log(result);
                        show_all(inst);
                        var callback = function() {
                            hidden.forEach(function(id) {
                                $('#' + id).addClass('jstree-hidden');
                                $('.jstree-grid-cell[data-jstreegrid="' + id + '"]').addClass('jstree-hidden');
                            });
                            if (result.length > 0) {
                                result.forEach(function(id) {
                                    $('#' + id + '_anchor').addClass('jstree-search');
                                });
                            } else {
                                toastr['warning']('Rất tiếc chúng tôi không tìm thấy tên bạn cần tìm', 'Không có kết quả');
                            }
                            UI('portlet').unblock();
                        };
                        if (opened.length > 0) {
                            const recursive = function() {
                                opened = opened.splice(1);
                                if (opened.length > 0) {
                                    inst.open_node(opened[0] + '', recursive);
                                } else {
                                    callback();
                                }
                            };
                            inst.open_node(opened[0] + '', recursive);
                        } else {
                            callback();
                        }
                    },
                    error: onError
                })
            }
        }
    </script>
    @if(Auth::check())
        <script>
            $('#upload').click(function() {
                bootbox.dialog({
                    title: 'Tải lên danh bạ',
                    message: $('#bootbox-content').html(),
                });
            });
        </script>
    @endif
@endsection