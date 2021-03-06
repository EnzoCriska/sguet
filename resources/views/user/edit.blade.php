@extends('layouts.page')

@section('page-title', 'Thay đổi thông tin người dùng')
@section('page-breadcrumb')
    <li>
        <a href="javascript:" class="sidebar-toggler menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">Quản lý</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="{{route('manage.user')}}">Người dùng</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="javascript:">{{$user->name}}</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <span>Thay đổi thông tin</span>
    </li>
@endsection

@section('page-body')
    <div class="portlet light">
        <div class="portlet-body">
            {!! Form::model($user, ['method' => 'post', 'route' => ['manage.user.update', $user->id], 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'create-user-form']) !!}
            <div class="form-body">
                <div class="form-group form-md-line-input @if($errors->has('name')) has-error @endif">
                    {!! Form::label('name', 'Tên hiển thị <span class="required">*</span>', ['class' => 'col-md-2 control-label'], false)!!}
                    <div class="col-md-10">
                        {!! Form::text('name', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Tên hiển thị', 'autofocus' => true]) !!}
                        <div class="form-control-focus"></div>
                        <div class="help-block {{$errors->has('name') ? 'help-block-error' : ''}}">{{$errors->first('name')}}</div>
                    </div>
                </div>

                <div class="form-group form-md-line-input @if($errors->has('username')) has-error @endif">
                    {!! Form::label('username', 'Tên đăng nhập <span class="required">*</span>', ['class' => 'col-md-2 control-label'], false) !!}
                    <div class="col-md-10">
                        {!! Form::text('username', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Tên đăng nhập']) !!}
                        <div class="form-control-focus"></div>
                        <div class="help-block {{$errors->has('username') ? 'help-block-error' : ''}}">{{$errors->first('username')}}</div>
                    </div>
                </div>

                <div class="form-group form-md-line-input @if($errors->has('password')) has-error @endif">
                    {!! Form::label('password', 'Mật khẩu', ['class' => 'col-md-2 control-label'], false) !!}
                    <div class="col-md-10 ">
                        <div class="input-icon">
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Mật khẩu']) !!}
                            <div class="form-control-focus"></div>
                            <i class="fa fa-key"></i>
                            <div class="help-block {{$errors->has('password') ? 'help-block-error' : ''}}">{{$errors->first('password') ?: 'Để trống nếu không muốn đổi mật khẩu'}}</div>
                        </div>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    {!! Form::label('password_confirmation', 'Nhập lại mật khẩu', ['class' => 'col-md-2 control-label'], false) !!}
                    <div class="col-md-10 ">
                        <div class="input-icon">
                            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Nhập lại mật khẩu']) !!}
                            <div class="form-control-focus"></div>
                            <i class="fa fa-key"></i>
                            <div class="help-block">Để trống nếu không muốn đổi mật khẩu</div>
                        </div>
                    </div>
                </div>

                <div class="form-group form-md-radios {{$errors->has('role_id') ? 'has-error' : ''}}">
                    <label class="col-md-2 control-label">
                        Nhóm quyền
                        <span class="required" aria-required="true">*</span>
                    </label>
                    <div class="col-md-10 md-radio-inline">
                        @foreach($roles as $index => $role)
                            <div class="md-radio">
                                {!! Form::radio('role_id', $role->id, $user->hasRole($role->name), ['class' => 'md-radiobtn', 'id' => 'role_id_' . $role->id]) !!}
                                <label for="role_id_{{$role->id}}">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{$role->display_name}} </label>
                            </div>
                        @endforeach
                        <div class="help-block {{$errors->has('role_id') ? 'help-block-error' : ''}}">{{$errors->first('role_id')}}</div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="row">
                    <div class="col-md-10 col-md-offset-2">
                        <button type="submit" class="btn blue">
                            Cập nhật
                        </button>
                    </div>
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>
@endsection