<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>LOADUS</title>


</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" yahoo="fix" style="font-family: 'Roboto', sans-serif; margin:0px; padding:0px;">

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
      @yield('content')
      
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

</body>
</html>