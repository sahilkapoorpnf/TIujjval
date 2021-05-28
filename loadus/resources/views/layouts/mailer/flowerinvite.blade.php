@extends('layouts.mailer.main')

@section('title')
LOADUS Invite
@endsection

@section('content')


  <h3>Dear {{$first_name}},</h3>

  <p>You are invited to join flower at LoadU$</p>

  <p>Please click on the link below to see flower requests:</p>
  <?php if(!empty($password)){?>
    <p style="font-size:20px; font-weight:500; color:#000; line-height:30px;">Your password is : <?php if(!empty($password)){?>{{$password}}<?php }?></p>
  <?php }?>
    
  <p><a href="{{$link}}" target="_blank" >Click here to Join Flower</a></p>

@endsection