@extends('layouts.mailer.main')

@section('title')
LOADUS Invite
@endsection

@section('content')


  <h3>Dear {{$first_name}},</h3>

  <p>You are invited to join group at LoadU$</p>

  <p>Please click on the link below to Join Group:</p>
  <?php if(!empty($password)){?>
    <p style="font-size:20px; font-weight:500; color:#000; line-height:30px;">Your password is : <?php if(!empty($password)){?>{{$password}}<?php }?></p>
  <?php }?>
    
  <p><a href="{{$link}}" target="_blank" >Click here to Join Group</a></p>

@endsection