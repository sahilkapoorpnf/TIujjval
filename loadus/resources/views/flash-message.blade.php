@if ($message = Session::get('success'))

<!--<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <i class="icon fa fa-check"></i>
    <strong>{{ $message }}</strong>

</div>-->
<script>
    PNotify.success({
            title: 'Success!',
             delay: 2500,
            text: '{{ $message }}'
          });
</script>

@endif


@if ($message = Session::get('error'))
<!--<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>	
    <i class="icon fa fa-ban"></i>
    <strong>{{ $message }}</strong>
</div>-->
<script>
    PNotify.error({
            title: 'Error!',
             delay: 2500,
            text: '{{ $message }}'
          });
</script>

@endif


@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>	
    <i class="icon fa fa-warning"></i>
    <strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>	
    <strong>{{ $message }}</strong>
</div>
@endif



