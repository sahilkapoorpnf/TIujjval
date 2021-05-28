@extends('adminlte::master')

@section('body_class', 'login-page')

@section('body')
<div class="login-box">
    <div class="login-logo">
        <!--<a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>-->
        <img src="{{ asset('public/frontend') }}/img/logo.png" style="margin-bottom:22px">
        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}"> <b>LOGIN</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            {{ session('success') }}
        </div>
        @endif 
        
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            {{ session('error') }}
        </div>
        @endif 
        <p class="login-box-msg">{{ trans('adminlte::adminlte.login_message') }}</p>
        <form action="{{ url('login_req') }}" method="post" autocomplete="off" id="login">
            {!! csrf_field() !!}

            <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                       placeholder="{{ trans('adminlte::adminlte.email') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                <input type="password" name="password" id="password" class="form-control"
                       placeholder="{{ trans('adminlte::adminlte.password') }}">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>

            
            <div class="clearfix"></div>
            <hr>

            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember"> {{ trans('adminlte::adminlte.remember_me') }}
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit"   class="btn btn-primary btn-block btn-flat">{{ trans('adminlte::adminlte.sign_in') }}</button>
                </div>
                <!-- /.col -->
            </div>

        </form>
        
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
@stop

@section('adminlte_js')
<script src="{{ asset('public/vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('public/vendor/adminlte/dist/js/sha256.js') }}"></script>
<script src="<?php echo URL::to('public/vendor/adminlte/dist/js/validation.js'); ?>"></script>

<script>
                        $(function () {
                            $('input').iCheck({
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%' // optional
                            });
                        });
</script>

<script type="text/javascript">
    
    
    $('#login').on('click').validate({
        rules: {
            email: {
                required: true,
                email: true,
                isemail: true,
            },
            password: {
                required: true,
            },
        }, messages: {
            email: {
                //required: "Email ID must be filled.",
//                email: "Email ID is incorrect.",
                isemail: "Email ID is incorrect.",
            },
//            password: {
//                required: "Password must be filled.",
//            }
        },
    });
    $.validator.addMethod("isemail", function (value) {
        return /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i.test(value)
    });
</script>
@yield('js')
@stop
