@extends('adminlte::master')

@section('adminlte_css')
<link rel="stylesheet" href="{{ asset('public/vendor/adminlte/css/auth.css') }}">
@yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>VISA</b>APP') !!}</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">{{ trans('adminlte::adminlte.password_reset_message') }}</p>
        <form action="{{ url(config('adminlte.password_reset_url', 'admin/password/reset')) }}" method="post">
            {!! csrf_field() !!}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                <input type="email" name="email" class="form-control" value="{{ isset($email) ? $email : old('email') }}"
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
            <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                       placeholder="{{ trans('adminlte::adminlte.retype_password') }}">
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
            </div>
            <button type="submit"  class="btn btn-primary btn-block btn-flat" onclick="hasashing()">{{ trans('adminlte::adminlte.reset_password') }}</button>
        </form>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
@stop

@section('adminlte_js')
<script src="{{ asset('public/vendor/adminlte/dist/js/sha256.js') }}"></script>
<script type="text/javascript">
    function hasashing() {
        //alert('aaa');
        if (document.getElementById('password').value != '') {
            var pass = document.getElementById('password').value + "<?php echo Config::get('constants.KEY.PKEY'); ?>";
            var hashpass = SHA256(pass)+"TR";
//             alert(hashpass);
            document.getElementById('password').value = hashpass;

            var cpass = document.getElementById('password_confirmation').value + "<?php echo Config::get('constants.KEY.PKEY'); ?>";
            var chashpass = SHA256(cpass)+"TR";
            document.getElementById('password_confirmation').value = chashpass;
        }
    }
</script>
@yield('js')
@stop
