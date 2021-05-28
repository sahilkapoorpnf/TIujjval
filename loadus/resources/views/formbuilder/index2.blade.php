@extends('adminlte::page')

@section('title',"$title")

@section('content_header')
<?php //echo ActionButton(1); ?>
<h1>{{$title}}</h1>
<ol class="breadcrumb">
    <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">{{ $title }}</a></li>    
</ol>



@stop

@section('content')
<div id="success"></div>
<div id="failed"></div>
<!--{{$form->form}}-->
<div class="box box-success color-palette-box">

    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> {{ $title }}</h3>
        <!--<button class="btn btn-success btn-flat pull-right">Add </button>-->
    </div>
    <div class="box-body">
        <div id="build-wrap"></div> 
    </div>

    <div class="box-footer">
        <div class="pull-right">
            <div class="setDataWrap"> 
                <button id="getJSON" type="button" class="btn btn-success btn-flat pull-right" >Save</button>
            </div>
        </div> 
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>



<script>

$(function ($) {
    var fbEditor = document.getElementById('build-wrap');
    var options = {
        formData: '<?php echo $form->form ?>',
        dataType: 'json',
        controlPosition: 'left',
        controlOrder: [
//        'autocomplete',
            'text',
            'textarea',
            'select',
            'radio-group',
            'checkbox-group',
        ],
        disableFields: ['autocomplete','button','file'],
    };
    var formBuilder = $(fbEditor).formBuilder(options);
    document.getElementById('getJSON').addEventListener('click', function () {
        var data = formBuilder.actions.getData('json');
        $.ajax({
            type: 'POST',
            url: "{{ url('admin/formbuildertwo/save') }}",
            data: {"_token": "{{ csrf_token() }}", data: data},
            success: function (result) {
                if (result == 1) {
                    PNotify.success({
                        title: 'Success!',
                        text: 'Your form has been saved successfuly!'
                    });
                } else {
                    PNotify.error({
                        title: 'Error!',
                        text: 'Some thing went wrong'
                    });
                }
            }

        });
    });

});
</script>
@stop