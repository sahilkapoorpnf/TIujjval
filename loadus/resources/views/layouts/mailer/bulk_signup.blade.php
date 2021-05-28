@extends('layouts.mailer.main')

@section('title')
LOADUS Signup
@endsection

@section('content')


            <h3>Dear {{$fname}},</h3>

            <p>Thank you for creating an account with us.</p>

            <p>Please click on the link below to login your account using your email ID and Password:</p>
            <p><strong>Email: </strong>{{$email}}</p>
            <p><strong>Password: </strong>{{$password}}</p>
            <p><a href="{{url('login')}}" target="_blank" >Click here to login your account</a></p>


@endsection