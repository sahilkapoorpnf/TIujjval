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
        <a href="{{url('/admin/flower')}}"><button class="btn btn-success btn-flat">Back</button></a>
    </div> 
</div>
@stop

@section('content')
<div class="box box-success color-palette-box col-md-6">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-tag"></i> {{ $titles }} </h3>
    </div>

    <div class="box-body">
      <!-- /.card-header -->
      <!-- form start -->
      <form id="formSubmit" role="form">
        
        
        <div class="card-body">
          <aside class="col-md-6">
            <div class="form-group">
              <label>Flower Owner / Water Position User</label>
              <select class="form-control" id="group_user_id" name="group_user_id" required>
                <option value="">Select Owner</option>
                <?php foreach ($users as $user) { 
                  $groupOwner = !empty($data->groupuser->id) ? $data->groupuser->id : '';
                ?>
                <option value="<?= $user->id?>" <?php if($groupOwner == $user->id){ echo "selected";} ?>><?php echo $user->first_name;?></option >
                <?php } ?>
              </select>
            </div>

            <div class="form-group">
              <label>Group</label>
              <select class="form-control group_class" id="group_id" name="group_id">
                <option value="">Select Group</option>
                <?php if(isset($data->id)){
                foreach ($user_Groups as $group) { 
                  $selectedId = !empty($data->parent_id) ? $data->parent_id : '';
                ?>
                <option value="<?= $group->id?>" <?php if($selectedId == $group->id){ echo "selected";} ?>><?php echo $group->name;?></option >
                <?php }} ?>
                
              </select>
            </div>


            <div class="form-group">
              <label>Flower Name</label>
              <input type="hidden" name="_token" value="{{ csrf_token() }}"   />
              <?php if(isset($data->id)){?>  
                <input type="hidden" name="old_group_image" value="{{ $data->image }}"   />
                <input type="hidden" id="id" name="id" value="{{ $data->id }}"   />
              <?php } ?>  
              <input class="form-control" id="name" name="name" value="<?php echo isset($data->name) ? $data->name : '';?>" required type="text" placeholder="Group name">
            </div>

            <div  class="form-group">
              <label>Flower Image</label>      
              <input   class="form-control" id="group_image" name="group_image" type="file">
            </div> 

            <?php 
              for($i = 1; $i<= config('constants.total_tiers'); $i++){
            ?>
              <div  class="form-group">
                <label>Price for Tier <?php echo $i; ?></label>      
                <input class="form-control" id="rate_tier<?php echo $i; ?>" name="rate_tier<?php echo $i; ?>" required type="number" value="<?php echo isset($data->tiers[$i-1]->price) ? $data->tiers[$i-1]->price : '';?>" placeholder="Tier <?php echo $i; ?> rate">
              </div>
            <?php } ?>

            
            <div class="form-group">
              <label >Flower Description</label>
              <textarea   id="description" rows="6" style="width: 100%;">
                <?php echo isset($data->description) ? $data->description : '';?>
              </textarea>
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
            <label>Flower Password</label>  
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
          <div class="card-footer">
          <button id="submitButton" type="submit" class="btn btn-primary">Submit</button>
        </div>
        </aside>

        <aside class="col-md-6">
          <div class="field_wrapper">
            <div class="addSecton">
              <div class="row userList" id="userList">
                                   
                <?php if(isset($data->id)){
                  /*$member = $memberPositions;
                  if(!empty($member)){
                    $j =1;
                    foreach($member as $key => $members){*/?>
                      <!-- <div class="userDiv row" id="div<?php //echo $j;?>">
                    
                        <div class="col-12 col-sm-6 col-md-4">
                          <div class="form-group">
                            <label>Position</label>
                            <select id="position<?php //echo $j;?>" class="form-control position_class" name="members_positions[<?php //echo $j-1;?>][position_id]"> -->
                                  <?php /*foreach ($position as $positions) { 
                                    $selectedId = $key;*/
                                  ?>
                                  <!-- <option value="<?php //echo $positions->id?>" <?php //if($selectedId == $positions->id){ echo "selected";} ?>><?php //echo $positions->name;?></option > -->
                                  <?php //} ?>
                            <!-- </select>
                          </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 memParent">
                          <div class="form-group">
                            <label>Members</label>
                            <select id="members<?php //echo $j;?>" class="form-control members" name="members_positions[<?php //echo $j-1;?>][member_id][]" onchange="loadMembers();" multiple> -->
                                  <?php /*foreach ($users as $user) {
                                    $selectedIds = array_column($members, 'member_id');*/
                                  ?>
                                  <!-- <option value="<?php //echo $user->id?>" <?php //if(in_array($user->id, array_values($selectedIds))){ echo "selected";} ?>><?php //echo $user->first_name;?></option > -->
                                  <?php //} ?>
                            <!-- </select>
                          </div>
                        </div>
                        <?php //if($j == 1){?>
                          <div class="col-12 col-sm-6 col-md-4" id="btnbtn">
                            <div class="form-group">
                              <label>Add More Users</label>
                              <input type="button" onclick="javascript:void(0);" class="add_button addBtn addMoreType form-control btn btn-success btn-circle btn-xl" value="Add More Users">
                            </div>
                          </div> -->
                        
                        <?php// }else{?>
                          <!-- <div class="col-12 col-sm-6 col-md-4" id="removeBtnId<?php //echo $j;?>">
                            <div class="form-group">
                              <label>Remove User</label>
                              <input type="button" onclick="javascript:void(0);" class="remove_button addBtn removeAddedType btn btn-danger btn-circle btn-xl" id="removeBtn<?php// echo $j;?>" value="Remove User">
                            </div>
                          </div>
                      <?php //}?>
                      </div> -->
                    <?php// $j++;}
                 // }else{?>
                    <!-- <div class="userDiv row" id="div1">
                      <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                          <label>Position</label>
                          <select id="position1" class="form-control position_class" name="members_positions[0][position_id]">
                                <?php //foreach ($position as $positions) { 
                                  
                                ?>
                                <option value="<?php //echo $positions->id?>" ><?php //echo $positions->name;?></option >
                                <?php //} ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-12 col-sm-6 col-md-4 memParent">
                        <div class="form-group">
                          <label>Members</label>
                          <select id="members1" class="form-control members" name="members_positions[0][member_id][]" onchange="loadMembers();">
                                <?php //foreach ($users as $user) { 
                                  
                                ?>
                                <option value="<?php//echo $user->id?>" ><?php //echo $user->first_name;?></option >
                                <?php// } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-12 col-sm-6 col-md-4" id="btnbtn">
                        <div class="form-group">
                          <label>Add More Users</label>
                          <input type="button" onclick="javascript:void(0);" class="add_button addBtn addMoreType form-control btn btn-success btn-circle btn-xl" value="Add More Users">
                        </div>
                      </div>
                    </div>
                     -->
                  <?php //}

                }else{?>  
                <div class="userDiv row" id="div1">
                  
                  <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                      <label>Position</label>
                      <select id="position1" class="form-control position_class" name="members_positions[0][position_id]">
                            <?php foreach ($position as $positions) { 
                              
                            ?>
                            <option value="<?= $positions->id?>" ><?php echo $positions->name;?></option >
                            <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-12 col-sm-6 col-md-4 memParent">
                    <div class="form-group">
                      <label>Members</label>
                      <select id="members1" class="form-control members" name="members_positions[0][member_id][]" onchange="loadMembers();">
                            <?php foreach ($users as $user) { 
                              
                            ?>
                            <option value="<?= $user->id?>" ><?php echo $user->first_name;?></option >
                            <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-4" id="btnbtn">
                    <div class="form-group">
                      <label>Add More Users</label>
                      <input type="button" onclick="javascript:void(0);" class="add_button addBtn addMoreType form-control btn btn-success btn-circle btn-xl" value="Add More Users">
                    </div>
                  </div>
                </div>
              <?php }?>
              </div>
            </div>
          </div>
        </aside>
        <!-- /.card-body -->
      
      
        

        
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
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>
<script>
  jQuery(document).ready(function($) {
    // loadMembers();

    var positiondata = <?php echo json_encode($position)?>;
    var usersData = <?php echo json_encode($users)?>;
    var selectedUsersData = [];
    var newUsersData = usersData;
    var minimum_members = "<?php echo config('constants.minimum_members');?>";

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


    // CKEDITOR.replace( 'description');
    CKEDITOR.replace('description',{
      customConfig : 'custom_config.js'
    });
    $("#submitButton").on('click',function(e){
      if($('#formSubmit')[0].checkValidity()) {
        e.preventDefault();
      
        var name=$("#name").val();
        var desc=CKEDITOR.instances['description'].getData();
        var formData = new FormData(document.getElementById("formSubmit"));

        /*-----Validation for selecting different positions : Start------------*/
        var emptyPositions = [];
        var positions_flag = true;
        var member_count_flag = true;
        var water_position_flag = true;
        var totalMembers = $(".members :selected").map(function (i, el) { return $(el).val(); }).get().length;
        
        $('.position_class').each(function(key, value){
          var position = $(value).val();
          var parentId = $(value).parent().parent().parent().attr("id");
          var memberscount = [];
          var memberscount = $("#"+parentId).find(".members :selected").map(function (i, el) { return $(el).val(); }).get().length;

          var result = positiondata.filter(obj => {
            return obj.id == position
          });
          if(position != 4 && memberscount != result[0].total_positions ){
            member_count_flag = false;
          }
          if(position == 1 ){
            water_position_flag = false;
          }

          if($.inArray(position, emptyPositions ) == -1){
            emptyPositions.push(position);
            positions_flag = true;
          }else{
            positions_flag = false;
          }

        });
        var all_positions_flag = true;
        if((emptyPositions.includes('2') == false) || (emptyPositions.includes('3') == false)){
          all_positions_flag = false;
        }else{
          all_positions_flag = true;
        }

        if(water_position_flag == false){
          swal('Flower owner considered as Water Position User, Please select different position');
          return false;
        }
        if(member_count_flag == false){
          swal('Please select allowed number of members for Earth and Air position Users');
          return false;
        }

        if(all_positions_flag == false){
          swal('Please select Earth and Air position Users');
          return false;
        }
        if(totalMembers < minimum_members){
          swal('Please select at least 7 members');
          return false;
        }

        
        if(positions_flag == false){
          swal('Please select different positions for members');
          return false;
        }
        
        
        /*-----Validation for selecting different positions : End------------*/

        formData.append('desc',desc);
    
        var group_id = $("#id").val();
        if(group_id != null && group_id != ''){
          var text = "For Update Flower";
          var url = "{{url('admin/flower/update')}}";
        }else{
          var text = "For Create Flower";
          var url = "{{url('admin/flower/store')}}";
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
                if(res.status==true){
                  window.location.href = "{{url('/admin/flower')}}";
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
   
    var addSection = function(num,newUsersData) {
      var index = num-1;
      var memberOption = '';
      $.each(newUsersData, function(index, value){
          memberOption += ('<option value="'+value.id+'">'+value.first_name+'</option>');
      });
      var fieldHTML = 
      // ``;
        '<div class="userDiv row '+num+'" id="div'+num+'">'+
            
            '<div class="col-12 col-sm-6 col-md-4">'+
                '<div class="form-group">'+
                    '<label>Position</label>'+
                    '<select id="position'+num+'" name="members_positions['+index+'][position_id]" class="form-control position_class" required>'+
                      <?php foreach ($position as $positions) { 
                        
                      ?>
                      '+<option value="<?= $positions->id?>" ><?php echo $positions->name;?></option >'+
                      <?php } ?>
                    '</select>'+
                '</div>'+
            '</div>'+
            
            '<div class="col-12 col-sm-6 col-md-4 memParent">'+
                '<div class="form-group">'+
                  '<label>Members</label>'+
                  '<select id="members'+num+'" class="form-control members" name="members_positions['+index+'][member_id][]" onchange="loadMembers();"><option class="emptyOption"></option>'+
                        memberOption
                  +'</select>'+
                '</div>'+
            '</div>'+
            
            
            
            '<div class="col-12 col-sm-6 col-md-4" id="removeBtnId'+num+'">'+
               '<div class="form-group">'+
                  '<label>Remove User</label>'+
                    '<input type="button" onclick="javascript:void(0);" class="remove_button addBtn removeAddedType btn btn-danger btn-circle btn-xl" id="removeBtn'+num+'" value="Remove User">'+
                '</div>'+

            '</div>'+
        '</div>'; //New input field html 
      return fieldHTML;
    }

    var maxField = 3;
    var addButton = $('.add_button');
    var wrapper = $('.field_wrapper');
    var numItems = $('.members').length;
    var x = numItems;
    $(addButton).click(function(){ 
      
      if(x < maxField){
        x++;
        var num = $('#userList').find('.userDiv').length;
        num += 1;
        let selectedUserList = $(".members :selected").map(function (i, el) { return $(el).val(); }).get();
        // usersData = <?php echo json_encode($users)?>;
        // for(var i = 0, len = selectedUserList.length; i < len; i++){
        //   usersData.splice(usersData.findIndex(v => v.id == selectedUserList[i]), 1);
        // }
        $('#userList').find('.userDiv:last').after(addSection(num, usersData));
        var newAddedDivId = $('#userList').find('.userDiv:last').attr("id");
        $('#'+newAddedDivId+' .members option').each(function(index, value){
          var idParent = $(this).parent().attr("id");
          for(var i = 0, len = selectedUserList.length; i < len; i++){
            if (this.value == selectedUserList[i]) {
              this.disabled = true;
            }
          }
        });
      } else {
        swal('You can not add more positions to this Flower');
      }
    });

    $(wrapper).on('click', '.remove_button', function(e){ 
      e.preventDefault();

      var selectedUserList = $(this).parents('.userDiv').find(".members :selected").map(function (i, el) { return $(el).val(); }).get();
      var newAddedDivId = $(this).parents('.userDiv').attr("id");
      $('.members option').each(function(index, value){
        var idParent = $(this).parent().attr("id");
        for(var i = 0, len = selectedUserList.length; i < len; i++){
          if (this.value == selectedUserList[i]) {
            this.disabled = false;
          }
        }
      });
      $('.position_class').each(function(key, value){
        var position = $(value).val();
        var parentId = $(value).parent().parent().parent().attr("id");
        var positiondata = <?php echo json_encode($position)?>;
        var result = positiondata.filter(obj => {
          return obj.id == position
        });
        var currentValue = $("#"+parentId).find(".members").val();
        if(currentValue != ''){
          $("#"+parentId).find(".members").select2({
            placeholder: 'Select Member',
            maximumSelectionLength: result[0].total_positions
          });  
        }
        
      });
      $(this).parents('.userDiv').remove();
      x--; 
    });
    $('body').on('change','.position_class', function(){
      var position_id = $(this).val();
      if(position_id != 0  && position_id != 1){
        // var positiondata = <?php //echo json_encode($position)?>;
        var result = positiondata.filter(obj => {
          return obj.id == position_id
        })
        $(".emptyOption").remove();
        var parentId = $(this).parent().parent().parent().attr("id");
        
        $('body').find("#"+parentId+" .members").attr('multiple','true');
        $('body').find("#"+parentId+" .members").attr('data-value',position_id);
        $('body').find("#"+parentId+" .members").select2({
          placeholder: 'Select Member',
          maximumSelectionLength: result[0].total_positions
        });
      }
    });

    $("#group_user_id").change(function(){  
      var id=$(this).val();
      if(id != ''){
        var dataString = 'id='+ id;
        
        $.ajax({
          type: "POST",
          url: "{{url('admin/flower/getGroups')}}",
          data:{ 
            "_token": "{{ csrf_token() }}", "id" : id
          },
          cache: false,
          success: function(html){ 
            $(".group_class").html(html);
          } 
        });
      }else{
        $(".group_class").html('<option value="">Select</option>');
      }
    });
  });
  function loadMembers(){
    var selectedOptions = $('.members option:selected');
    $('.members option').removeAttr('disabled');
    $(".emptyOption").remove();
    selectedOptions.each(function() {     
        var value = this.value;
        if (value !== ''){        
          var id = $(this).parent('select[name*="members"]').prop('id');

          var options = $('select[name*="members"]:not(#' + id + ') option[value=' + value + ']');
          options.prop('disabled', 'true');
        }
    });

    $('.position_class').each(function(key, value){
      var position = $(value).val();
      var parentId = $(value).parent().parent().parent().attr("id");
      var positiondata = <?php echo json_encode($position)?>;
      var result = positiondata.filter(obj => {
        return obj.id == position
      });
      var currentValue = $("#"+parentId).find(".members").val();
      if(currentValue != ''){
        $("#"+parentId).find(".members").select2({
          placeholder: 'Select Member',
          maximumSelectionLength: result[0].total_positions
        });  
      }
      
    });     
  }

  $(window).on('load',function(e) {
    var flowerId = '<?= isset($data->id) ? $data->id : '';?>';
    if(flowerId != ''){
      setTimeout(function() {
        $('.position_class').each(function(key, value){
          var position = $(value).val();
          var parentId = $(value).parent().parent().parent().attr("id");
          var positiondata = <?php echo json_encode($position)?>;
          var result = positiondata.filter(obj => {
            return obj.id == position
          });
          var currentValue = $("#"+parentId).find(".members").val();
          var selectedOptions = $("#"+parentId+' option:selected');
          // $('.members option').removeAttr('disabled');
          $(".emptyOption").remove();
          selectedOptions.each(function() {     
            var value = this.value;
            if (value !== ''){        
              var id = $(this).parent('select[name*="members"]').prop('id');
              var options = $('select[name*="members"]:not(#' + id + ') option[value=' + value + ']');
              options.prop('disabled', 'true');
            }
          });
          if(currentValue != ''){
            $("#"+parentId).find(".members").select2({
              placeholder: 'Select Member',
              maximumSelectionLength: result[0].total_positions
            }); 
          }
        });
      }, 0);
    }

  });
</script>
@stop