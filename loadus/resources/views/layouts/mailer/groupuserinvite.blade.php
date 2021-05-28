@extends('layouts.mailer.main')

@section('title')
LOADUS Invite
@endsection

@section('content')


  <h3>Dear {{$first_name}},</h3>

  <p>{{$logged_in_user}} has invited you to join his groups at LoadU$</p>
  
  <p> Please signup and login on loadus and join the group to explore multiple flowers.</p>

  <p>Please click here to see groups</p>
    
  <p><a href="{{$link}}" target="_blank" >Click here to See Group</a></p>

@endsection
