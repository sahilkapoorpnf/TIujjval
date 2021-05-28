
@include('layouts.sahil-header-script')

<body >
@if(Session::has('message'))
<div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	{{ Session::get('message') }}
</div>
@endif	
@include('layouts.sahil-header')

@yield('content')

@include('layouts.sahil-footer')
@include('layouts.sahil-footer-script')
@stack('script')
</body>
</html>