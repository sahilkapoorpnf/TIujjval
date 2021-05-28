<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>PassYaFail</title>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" yahoo="fix" style="font-family: 'Roboto', sans-serif; margin:0px; padding:0px;">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle">
      <table width="650px" border="0" cellspacing="0" cellpadding="0" style="background-color:#f1fcff;">
        <tr>
          <td align="right" valign="bottom" height="80" style="background:#FFF;"><img src="{{asset('site/mailer/bg-top-1.jpg')}}"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center" valign="middle"><img src="{{asset('site/mailer/logo.png')}}"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>
            <p style="margin:0px; padding:0px 40px; font-size:25px; font-weight:bold; color:#f04a4e;">
                {{$message}}
            </p>
          </td>
        </tr>

        <tr><td>&nbsp;</td></tr>

        <tr>
          <td style="margin:0px; padding:0px 40px;">
            <div style="margin:0px; padding:25px; background:#FFF; border-radius:10px;">
              @if(!empty($status))
              <p style="margin:0px; padding:0px; font-size:19px; font-weight:500; color:#000; line-height:28px;">Congratulations! You’re now a member of the Pass ya Fail community. Feels pretty good, huh?</p>
              @endif
              <p style="margin:0px; padding:15px 0px; font-size:19px; font-weight:500; color:#000; line-height:28px;">Pass ya Fail lets verified members participate in contests, make predictions, and win real prizes!</p>

              <div style="background:#d8e2e5; width:100%; height:2px;"></div>

              <p style="margin:0px; padding:15px 0 0; font-size:19px; font-weight:500; color:#000; line-height:28px;">For every contest you participate, you get a chance to win Apple iWatch, cash prizes, gift vouchers, movie tickets, mobile, and more exciting rewards, every time.</p>
            </div>
          </td>
        </tr>

        <tr><td>&nbsp;</td></tr>

        <tr><td>&nbsp;</td></tr>

        <tr>
          <td style="margin:0px; padding:0px 40px;">
            <div style="background:#d8e2e5; width:100%; height:2px;"></div>
          </td>
        </tr>

        

        <tr>
          <td align="center" valign="middle" style="margin:0px; padding:20px 40px 25px">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="middle">
                  <p style="margin:0px; padding:15px 15px 0; font-size:28px; color:#5f5f5f; font-weight:500;">
                    <img src="{{asset('site/mailer/bullet.png')}}" style="vertical-align:middle; padding-bottom:6px;"> Play for fun.</p>
                  <p style="margin:0px; padding:5px 15px; font-size:28px; color:#5f5f5f; font-weight:500;">
                    <img src="{{asset('site/mailer/bullet.png')}}" style="vertical-align:middle; padding-bottom:6px;"> Play to learn.</p>
                  <p style="margin:0px; padding:0px 15px 20px; font-size:28px; color:#5f5f5f; font-weight:500;">
                    <img src="{{asset('site/mailer/bullet.png')}}" style="vertical-align:middle; padding-bottom:6px;"> Play to earn.</p>
                  <a href="{{url('/')}}" target="_blank" style="margin:0px; display:block; padding:12px 0; border:0px; border-radius:40px; color:#FFF; background:#f04a4e; font-size:23px; text-align:center; text-decoration:none;">Play Now</a>
                </td>

                <td style="text-align:center;">
                  <img src="{{asset('site/mailer/award-2.png')}}">
                  <p style="margin:0px; padding:10px 0px 0px; font-size:22px; font-weight:500; text-align:center;"><img src="{{asset('site/mailer/thum.png')}}"> We Wish you unlimited fun</p>
                </td>
              </tr>

            </table>
          </td>
        </tr>


        <tr>
          <td style="margin:0px; padding:0px 40px;">
            <div style="background:#d8e2e5; width:100%; height:2px;"></div>
          </td>
        </tr>

        <tr><td>&nbsp;</td></tr>
        @include('layouts.mailer.common_footer')
        {{-- <tr>
          <td align="center" valign="top" style="margin:0px; padding:0px 40px;">
            <p style="margin:0px; padding:0 0 20px; font-size:20px;">P.S. Don't forget to connect with us on</p>
          </td>
        </tr>

        <tr>
          <td align="center" valign="middle" style="margin:0px; padding:0px 40px;">
            <a href="https://www.facebook.com/" target="_blank" style="display:inline-block; padding:0px; margin:0 2px;"><img src="{{asset('site/mailer/facebook.png')}}"></a>
            <a href="https://www.instagram.com/" target="_blank" style="display:inline-block; padding:0px; margin:0 2px;"><img src="{{asset('site/mailer/instagram.png')}}"></a>
            <a href="https://twitter.com/explore" target="_blank" style="display:inline-block; padding:0px; margin:0 2px;"><img src="{{asset('site/mailer/twitter.png')}}"></a>
            <a href="https://www.linkedin.com/" target="_blank" style="display:inline-block; padding:0px; margin:0 2px;"><img src="{{asset('site/mailer/linkedin.png')}}"></a>
          </td>
        </tr>

        <tr><td>&nbsp;</td></tr>

        <tr>
          <td align="center" valign="middle" style="background:#FFF;">
            <img src="{{asset('site/mailer/bg-bottom-1.jpg')}}">
          </td>
        </tr> --}}

      </table>
    </td>
  </tr>
</table>

</body>
</html>