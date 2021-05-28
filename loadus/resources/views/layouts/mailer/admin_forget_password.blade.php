@extends('layouts.mailer.main')

@section('title')
 Loadus
@endsection

@section('content')


    <h3>Dear {{$fname}},</h3>

    <p>Please click on the below link to reset password:</p>
    <p><a href="{{url('admin_reset_verification'.'/'.$email.'/'.$token)}}" target="_blank" >Reset Password</a></p>

@endsection