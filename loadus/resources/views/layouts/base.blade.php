
@include('layouts.header_script')

<body >
@if(Session::has('message'))
<div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	{{ Session::get('message') }}
</div>
@endif	
@include('layouts.header')

@yield('content')

@include('layouts.footer')
@include('layouts.footer_script')
@stack('script')
</body>
</html>