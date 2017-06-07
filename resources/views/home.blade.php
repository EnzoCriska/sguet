@extends('layouts.page')

@section('page-level-styles')
    @parent
    {{ Html::style('css/sguet/cover-image.css') }}
    {{ Html::style('metronic/pages/css/faq.min.css') }}
    <style>
        .no-boder-radius {
            border-radius: 0 !important;
        }

        .sg-header > div {
            margin: calc((170px - 97px) / 2) 0;
        }

        .sg-header h1 {
            font-size: 50px;
            font-weight: 600;
            text-shadow: 1px 1px 0 rgba(0, 0, 0, .2);
        }

        .sg-header h2 {
            font-size: 20px;
            font-weight: 400;
        }

        .vertical-center {
            margin-top: calc(
                    (100vh
                    - (58px + 33px)/* header + footer */
                    - 236px/* container */
                    - (170px + 20px)/* sg-header */) / 2
                    - 25px /* padding-top */
            );
        }
    </style>
@endsection

@section('page-body')
    <div class="container-fluid vertical-center">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                <div class="row row-eq-height">
                    <div class="col-md-3 col-sm-3 hidden-xs">
                        <img src="{{asset('img/SGUET.png')}}" alt="SGUET" style="width: 100%">
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12 font-white text-center sg-header">
                        <div>
                            <h1>Support Group UET</h1>
                            <h2>CLB HỖ TRỢ SINH VIÊN TRƯỜNG ĐH CÔNG NGHỆ</h2>
                        </div>
                    </div>
                </div>
                <div class="row margin-top-20">
                    <div class="col-md-12">
                        {{Form::open(['method' => 'get', 'route' => 'home', 'id' => 'search-form'])}}
                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control no-boder-radius" placeholder="Nhập từ khoá, tên người, tên đơn vị..."
                                   autofocus required name="query" value="{{request('query')}}">
                            <span class="input-group-btn">
                                <button class="btn green-soft uppercase bold no-boder-radius" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
                <div class="row margin-top-20" id="search-result-container" @if(!isset($faqs))style="display: none"@endif>
                    @if(isset($faqs))
                        @include('partials.home.results')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-level-plugins.scripts')
    @parent
    {{ Html::script('metronic/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js') }}
@endsection

@section('page-level-scripts')
    @parent
    <script>
        $(function () {
            var form = $('#search-form');

            form.submit(function (e) {
                e.preventDefault();
                var loading = bootbox.loading({message: 'Đang tìm kiếm'});
                window.history.pushState({}, '{{config('app.name')}}', '{{route('home')}}?' + $(this).serialize());
                $.ajax({
                    method: 'get',
                    url: '{{route('home')}}',
                    data: $(this).serialize()
                }).done(function(response) {
                    var container = $('#search-result-container');
                    container.html(response);
                    container.slideDown();
                    App.scrollTo(container, 1);
                    loading.modal('hide');
                }).fail(function(e) {
                    @if(config('app.debug'))
                        $('html').html(e.responseText);
                    @endif
                    toastr['error']('Đã có lỗi trong quá trình tìm kiếm. Vui lòng thử lại sau.', 'Lỗi không xác định');
                    loading.modal('hide');
                });
            });

            @if(isset($faqs))
                App.scrollTo($('#search-result-container'), 1);
            @endif
        });
    </script>
@endsection