@extends('layouts.mailer.main')

@section('title')
LOADUS Signup
@endsection

@section('content')


            <h3>Dear {{$fname}},</h3>

            <p>Thank you for creating an account with us.</p>

            <p>Please click on the link below to verify your email ID:</p>
            <p><a href="{{url('signup_mail_verification'.'/'.$email.'/'.$token)}}" target="_blank" >Click here to verify your email</a></p>


@endsection