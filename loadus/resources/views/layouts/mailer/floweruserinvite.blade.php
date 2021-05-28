@extends('layouts.mailer.main')

@section('title')
LOADUS Invite
@endsection

@section('content')


  <h3>Dear {{$first_name}},</h3>

  <p>{{$logged_in_user}} has invited you to join his flowers at LoadU$</p>
  
  <p> Please signup and login on loadus to explore multiple groups and their flowers.</p>

  <p>Please click here to see flowers</p>
    
  <p><a href="{{$link}}" target="_blank" >Click here to See Flowers</a></p>

@endsection
