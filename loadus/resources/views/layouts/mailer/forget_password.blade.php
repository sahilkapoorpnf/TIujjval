@extends('layouts.mailer.main')

@section('title')
 Loadus
@endsection

@section('content')


    <h3>Dear {{$first_name}},</h3>

    <p>Please click on the below link to reset password:</p>
    <p><a href="{{url($link)}}" target="_blank" >Reset Password</a></p>

@endsection