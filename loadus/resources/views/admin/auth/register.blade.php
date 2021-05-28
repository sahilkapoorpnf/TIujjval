@extends('adminlte::master')

@section('adminlte_css')
<link rel="stylesheet" href="{{ asset('public/vendor/adminlte/css/auth.css') }}">
@yield('css')
@stop

@section('body_class', 'register-page')

@section('body')
<div class="register-box">
    <div class="register-logo">
        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>VISA  </b>APP') !!}</a>
    </div>


    <div class="register-box-body">
        <p class="login-box-msg">{{ trans('adminlte::adminlte.register_message') }}</p>
        
        @if ($message = Session::get('success'))
        <p class="login-box-msg text-success"><strong> {{ $message }} </strong></p>
        
        @endif
        
        <form action="{{ url(config('adminlte.register_url', 'register')) }}" method="post">
            {!! csrf_field() !!}

            <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                       placeholder="{{ trans('adminlte::adminlte.full_name') }}">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
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
            <input type="hidden" name="role" value="2" >
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
            
            <div class="form-group has-feedback {{ $errors->has('captcha') ? 'has-error' : '' }}">
                <div class="col-md-5" style="padding-left: 0">
                    <input type="text" name="captcha" class="form-control"  placeholder="Captcha">
                </div>
                <div class="col-md-2" style="padding-left: 5px"> 
                    <a href="javascript:void(0)" onclick="refreshCaptcha()">
                        <img src="{{ asset('public/vendor/img/refresh-1.png') }}" style="width: 100%">
                    </a>
                </div>
                <div class="col-md-5 refereshrecapcha">                       
                    {!! captcha_img('inverse') !!}
                </div>
                

                <span class="help-block">
                    <strong>{{ $errors->first('captcha') }}</strong>
                </span>

            </div>
            <div class="clearfix"></div>
            <hr>
            
            <button type="submit" class="btn btn-primary btn-block btn-flat" onclick="hasashing()">{{ trans('adminlte::adminlte.register') }}</button>
        </form>
        <div class="auth-links">
            <a href="{{ url(config('adminlte.login_url', 'login')) }}"
               class="text-center">{{ trans('adminlte::adminlte.i_already_have_a_membership') }}</a>
        </div>
    </div>
    <!-- /.form-box -->
</div><!-- /.register-box -->
@stop

@section('adminlte_js')

<script src="{{ asset('public/vendor/adminlte/dist/js/sha256.js') }}"></script>
<script>
    function refreshCaptcha() {
        $.ajax({
            url: "<?php echo URL::to('/'); ?>/mycapcha",
            type: 'POST',
            data: {"_token": "{{ csrf_token() }}"},
            dataType: 'html',
            success: function (json) {
                $('.refereshrecapcha').html(json);
            },
            error: function (data) {
                alert('Try Again.');
            }
        });
    }
</script>
<script type="text/javascript">
    function hasashing() {
        if (document.getElementById('password').value != '') {
            var pass = document.getElementById('password').value + "<?php echo Config::get('constants.KEY.PKEY'); ?>";
            var hashpass = SHA256(pass);
            // alert(hashpass);
            document.getElementById('password').value = hashpass;
            
            var cpass = document.getElementById('password_confirmation').value + "<?php echo Config::get('constants.KEY.PKEY'); ?>";
            var chashpass = SHA256(cpass);
            document.getElementById('password_confirmation').value = chashpass;
        }
    }
</script>
@yield('js')
@stop
