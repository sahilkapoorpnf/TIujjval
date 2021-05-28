@extends('layouts.mailer.main')

@section('title')
LOADUS Invite
@endsection

@section('content')


  <h3>Dear {{$first_name}},</h3>

  <p><h4>{{$user_first_name}}</h4> has requested to join your flower at LoadU$</p>

  <p>Please click on the link below to see requests:</p>
    
  <p><a href="{{$link}}" target="_blank" >Click here to see requests</a></p>

@endsection