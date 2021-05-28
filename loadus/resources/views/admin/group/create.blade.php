@extends('adminlte::page')

@section('title', $titles)

@section('content_header')

<h1>{{ $titles }}</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">{{ $titles }}</a></li>    
</ol>
<div class="clearfix cbutton">
    <div class="pull-right">
        <a href="{{url('/admin/group')}}"><button class="btn btn-success btn-flat">Back</button></a>
    </div> 
</div>
@stop

@section('content')
<div class="box box-success color-palette-box">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-tag"></i> {{ $titles }} </h3>
    </div>

    <div class="box-body">
      <!-- /.card-header -->
      <!-- form start -->
      <form id="formSubmit" role="form">
        <div class="card-body">

          
          <div class="form-group">
            <label>Group Owner</label>
            <select class="form-control" id="group_user_id" name="group_user_id">
              <option value="">Select Owner</option>
              <?php foreach ($users as $user) { 
                $groupOwner = !empty($data->groupuser->id) ? $data->groupuser->id : '';
              ?>
              <option value="<?= $user->id?>" <?php if($groupOwner == $user->id){ echo "selected";} ?>><?php echo $user->first_name;?></option >
              <?php } ?>
            </select>
          </div>


          <div class="form-group">
            <label>Group Name</label>
            <input type="hidden" name="_token" value="{{ csrf_token() }}"   />
            <?php if(isset($data->id)){?>  
              <input type="hidden" name="old_group_image" value="{{ $data->image }}"   />
              <input type="hidden" id="id" name="id" value="{{ $data->id }}"   />
            <?php } ?>  
            <input class="form-control" id="name" name="name" value="<?php echo isset($data->name) ? $data->name : '';?>" required type="text" placeholder="Group name">
          </div>

          <div  class="form-group">
            <label>Group Image</label>      
            <input   class="form-control" id="group_image" name="group_image" type="file">
          </div> 

          <?php 
           // for($i = 1; $i<= config('constants.total_tiers'); $i++){
          ?>
           <!--  <div  class="form-group">
              <label>Price for Tier <?php //echo $i; ?></label>      
              <input class="form-control" id="rate_tier<?php// echo $i; ?>" name="rate_tier<?php //echo $i; ?>" required type="number" value="<?php //echo //isset($data->tiers[$i-1]->price) ? $data->tiers[$i-1]->price : '';?>" placeholder="Tier <?php //echo $i; ?> rate">
            </div> -->
          <?php// } ?>

          
          <div class="form-group">
            <label >Group Description</label>
            <textarea   id="description" rows="6" style="width: 100%;">
              <?php echo isset($data->description) ? $data->description : '';?>
            </textarea>
          </div>
        </div>

        <div class="form-group">
          <label>Privacy</label>
          <?php
          $select = isset($data->privacy) ? $data->privacy : Input::get('privacy');
          $privacy = [ '1' => 'Public', '0' => 'Private'];
          echo Form::select('privacy', $privacy, $select, ['class' => 'form-control', 'id'=>'privacy']);
          ?>
        </div>
        <div class="form-group" id="group_password" style="display: hidden">
          <label>Group Password</label>  
          <input class="form-control" id="password" name="password" value="<?php echo isset($data->password) ? $data->password : '';?>" type="text" placeholder="Group Password">
        </div>


        <div class="form-group">
          <label>Status</label>
          <?php
          $select = isset($data->status) ? $data->status : Input::get('status');
          $status = ['' => '---Select---', '1' => 'Active', '0' => 'In-Active'];
          echo Form::select('status', $status, $select, ['class' => 'form-control']);
          ?>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button id="submitButton" type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
<link rel="stylesheet" href="{{asset('public/vendor/toastr/build/toastr.css')}}">
<link rel="stylesheet" href="{{asset('public/vendor/sweetalert2/dist/sweetalert2.css')}}">
<script src="{{asset('public/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script src="{{asset('public/vendor/parsleyjs/dist/parsley.min.js')}}"></script>
<script src="{{asset('public/vendor/ckeditor4/ckeditor.js')}}"></script>
<script src="{{asset('public/vendor/toastr/build/toastr.min.js')}}"></script>
<script>
jQuery(document).ready(function($) {
	  



		window["closeLoading"] = function() {
		 Swal.close();
	  
		};
	  
		window["showLoading"] = function() {
		Swal.fire({
			title: 'loading...',
			closeOnEsc: false,
			allowOutsideClick: false,
	  
			showCancelButton: false, 
			showConfirmButton: false ,
			onOpen: () => {
			  swal.showLoading();
			}
		  });
	  
	  };

      var privacy = $( "#privacy option:selected" ).val();
      if(privacy == 0){
        $('#group_password').show();
      }else{
        $('#group_password').hide();
      }

      $('body').on('change','#privacy', function(){
        var privacy = $( "#privacy option:selected" ).val();
        if(privacy == 0){
          $('#group_password').show();
        }else{
          $('#group_password').hide();
        }
      });

	  });

toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

$(function() {
           $('#table').DataTable({
           processing: true,
           serverSide: true,
           ordering: false,
           ajax: '{{ url('admin/list-group') }}',  
           columns: [
                    { data: 'group_name', name: 'group_name' },
                    { data: 'tier1_price', name: 'tier1_price' },
                    { data: 'tier2_price', name: 'tier2_price' },
                    { data: 'tier3_price', name: 'tier3_price' },
                   { data: 'action',name: 'action', orderable: false, searchable: false},
                   
                  ]
        }).on('click', '.danger', function (e) { 
        
          e.preventDefault();
          var ID=this.id;
          swal.fire({
         title: "Are you sure?",
         text: "Delete this record!",
         icon: "warning",
         buttons: [
           'No, cancel it!',
           'Yes, I am sure!'
         ],
         dangerMode: true,
       }).then(function(isConfirm) {
         if (isConfirm.value) {
           $.ajax({

              url: "{{ url('admin/delete-group') }}",
              type:"POST",
              data:{ 
                 
                 "_token": "{{ csrf_token() }}",
                 "id" : ID
                 },
              dataType: 'json',
              success: function(data){
                 console.log(data);
              if(data.status==true)
              {
                
               $('#table').DataTable().ajax.reload();
               
               swal.fire({
               title: 'Deleted!',
               text: 'Deleted successfully',
               icon: 'success'
               }).then(function() {
                 
                 
               });
                
              }}
              });

           
         } else {
           swal.fire("Cancelled", "Your record is safe :)", "error");
         }
       });








     });
        
     });




     

CKEDITOR.replace( 'description');
 $("#submitButton").on('click',function(e){
 
if($('#formSubmit')[0].checkValidity()) {
    
    e.preventDefault();
    
    var name=$("#name").val();
    var desc=CKEDITOR.instances['description'].getData();

  var formData = new FormData(document.getElementById("formSubmit"));
  
  formData.append('desc',desc);
  
  var group_id = $("#id").val();
  if(group_id != null && group_id != ''){
    var text = "For Update Group";
    var url = "{{url('admin/group/update')}}";
  }else{
    var text = "For Create Group";
    var url = "{{url('admin/group/store')}}";
  }
    
   const swalWithBootstrapButtons = Swal.mixin({
       customClass: {
         confirmButton: 'btn btn-success',
         cancelButton: 'btn btn-danger'
       },
       buttonsStyling: false
     })
     swalWithBootstrapButtons.fire({
       title: 'Are you sure?',
       text: text,
       icon: 'warning',
       showCancelButton: true,
       confirmButtonText: "Yes Post",
       cancelButtonText: 'No, cancel!',
       reverseButtons: true
     }).then((result) => {
       if (result.value) {

  
   window.showLoading();
   
   
    $.ajax({
            type:'POST',
            url: url,
            data:formData,
            cache:false,
            contentType: false,
            processData: false,

           success:function(res){
            window.closeLoading();
               console.log(res);
              if(res.status==true)
              {

                // $('#formSubmit').trigger("reset");
                // CKEDITOR.instances.description.setData('');
                
                // $('#table').DataTable().ajax.reload();
                // toastr.success(res.message);
                window.location.href = "{{url('/admin/group')}}";
                
                 
              }else{
                  jQuery.each(res.errors, function(key, value){
                      toastr.error(value);    
                
                  });

                              
                  }
                 
           }
          
   
        });
      } else if (
         /* Read more about handling dismissals below */
         result.dismiss === Swal.DismissReason.cancel
       ) {
         swalWithBootstrapButtons.fire(
           'Cancelled',
           'Not saved try agin:)',
           'error'
         )
       }
     })

    }else{
       $("#formSubmit").parsley();
   }


    
 });
 </script>
@stop