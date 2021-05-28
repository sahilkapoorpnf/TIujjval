@extends('layouts.mailer.main')

@section('title')
LOADUS Signup
@endsection

@section('content')

<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td align="left" valign="top" style="background:#2b98de;text-align:center; padding:15px 0;">
            <a href="{{url('/')}}" style="text-decoration:none;" target="_blank">
                <img src="{{url('public/frontend/img/logo.png')}}" height=""/>
                <!--<i><img src="{{url('public/frontend/img/logo.png')}}" height=""/></i>-->
            </a>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" style="border:1px solid #e1e1e1; padding:20px;">
            <h3>Dear {{$first_name}},</h3>

            <p>Thank you for contact with us.</p>

            <p>Please click on the link below to verify your email ID:</p>
            <!--<p><a href="{{url('signup_mail_verification'.'/'.$email.'/'.$token)}}" target="_blank" >Click here to verify your email</a></p>-->

            <table>
                <tbody>
                    <tr>
                        <td>Thank you for assisting us in serving you better.</td>
                    </tr>
                    <tr>
                        <td>
                            <p>&nbsp;</p>

                            <p>&nbsp;</p>
                            <a href="{{url('/')}}">Team Loadus</a>

                            <p>&nbsp;</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>

@endsection