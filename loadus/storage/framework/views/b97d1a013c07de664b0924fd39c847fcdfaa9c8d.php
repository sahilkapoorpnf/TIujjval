<?php $__env->startSection('title'); ?>
LOADUS
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php 
	if(!empty($user->user_image)){
		$user_image = $user->user_image;
	}else{
		$user_image = 'user_profile.jpg';
	}
?>
<style>
    .weekDays-selector input {
  display: none!important;
}

.weekDays-selector input[type=checkbox] + label {
  display: inline-block;
  border-radius: 6px;
  background: #dddddd;
  height: 40px;
  width: 30px;
  margin-right: 3px;
  line-height: 40px;
  text-align: center;
  cursor: pointer;
}

.weekDays-selector input[type=checkbox]:checked + label {
  background: #4950FF;
  color: white;
}
</style>
<section class="dashbaord p-0">
	<div class="container">
		<button class="menu-btn"><img src="<?php echo e(asset('public/frontend/img/menu.png')); ?>"></button>
		<div class="row">
			<?php echo $__env->make('layouts.left_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<div class="col">
				<div class="dshContent">
					<h2 class="title blue">Add Business <span>(You can add maximum two businesses)</span></h2>
					<hr>
					<?php if(session()->has('success')): ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php echo e(session()->get('success')); ?>

                    </div>
                    <?php endif; ?>
                    
                    <?php if(session()->has('error')): ?>
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php echo e(session()->get('error')); ?>

                    </div>
                    <?php endif; ?>
					<form method="post" enctype="multipart/form-data">
					    <?php echo e(csrf_field()); ?>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Business Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Business Title">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Business Description</label>
                        <textarea class="form-control" name="description" placeholder="Business Description"></textarea>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Category</label>
                            <select class="selectpicker" name="sub_category_ids[]" multiple data-live-search="true" required>
                             <?php $__currentLoopData = $sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    
                              <option value="<?php echo e($sub_category->id); ?>"><?php echo e($sub_category->title); ?></option>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                      <div class="weekDays-selector form-group">
                          <label for="exampleInputEmail1">Open Days</label>
                          <br>
                          <input type="checkbox" name="day[]" value="mon" id="weekday-mon" class="weekday" />
                          <label for="weekday-mon">M</label>
                          <input type="checkbox" name="day[]" value="tue" id="weekday-tue" class="weekday" />
                          <label for="weekday-tue">T</label>
                          <input type="checkbox" name="day[]" value="wed" id="weekday-wed" class="weekday" />
                          <label for="weekday-wed">W</label>
                          <input type="checkbox" name="day[]" value="thu" id="weekday-thu" class="weekday" />
                          <label for="weekday-thu">T</label>
                          <input type="checkbox" name="day[]" value="fri" id="weekday-fri" class="weekday" />
                          <label for="weekday-fri">F</label>
                          <input type="checkbox" name="day[]" value="sat" id="weekday-sat" class="weekday" />
                          <label for="weekday-sat">S</label>
                          <input type="checkbox" name="day[]" value="sun" id="weekday-sun" class="weekday" />
                          <label for="weekday-sun">S</label>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Open From</label>
                            <input type="time" class="form-control" name="open_time" required>
                         </div>
                         <div class="form-group">
                            <label for="exampleInputEmail1">Close From</label>
                            <input type="time" class="form-control" name="close_time" required>
                         </div>
                         <div class="form-group">
                        <label for="exampleInputEmail1">Services Offered</label>
                        <textarea class="form-control" name="services" placeholder="Services Offered"></textarea>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Tags</label>
                       <input type="text" class="form-control" value="" name="tags" data-role="tagsinput" />
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Phone</label>
                        <input type="tel" class="form-control" name="phone" placeholder="Phone" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Address</label>
                        <textarea class="form-control" name="address" placeholder="Address"></textarea>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Website</label>
                        <input type="url" class="form-control" name="url" placeholder="https://" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Location</label>
                        <input type="text" id="autocomplete_search" class="form-control " placeholder="" name="source" required> 
                        <input type="hidden" id="source_lat" name="lat_source">
                        <input type="hidden" id="source_long" name="source_long">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Images</label>
                        <input type="file" class="form-control" name="images[]" multiple required>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
				</div>
			</div>
		</div>
	</div>
</section>	
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo e(asset('public/frontend/js/bootstrap-tagsinput.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/frontend/js/bootstrap-tagsinput-angular.min.js')); ?>" type="text/javascript"></script>
<script type="text/javascript">
	
    $(document).ready(function() {

		$('#updateProfile').validate({
	        rules: {
	           "first_name": {required: true},
	           "phone": {required: true},
	           "email": {required: true, email:true},
	        },
	        messages:{
	            "first_name":{required: "Please enter first_name"},
	            "phone":{required: "Please enter Contact Number"},
	            "email":{required: "Please enter valid email", email: "Please enter valid email"},
	        },

	        submitHandler: function(){

	            $.ajax({
		            url:"<?php echo e(url('updateProfile')); ?>",
		            type:"POST",
		            data: new FormData($('#updateProfile')[0]),
		            dataType:'json',
		            contentType:false,
		            cache:false,
		            processData:false,
		            success:function(data){
		                if(data.status === true){
		                 // window.location.reload();
		                	// window.location.href = "/";
		                	showMessage(data.msg, success=true);
		                }else if(data.status === '5'){
		                	window.location.href = "<?php echo e(url('login')); ?>"; 
		                }else{
		                  showMessage(data.msg, success=false);
		                }
	            	},
	            	error: function (xhr, err) {
						var errMsg = formatErrorMessage(xhr, err);
						showMessage(errMsg, success=false);
			        }
	        	});
	    	},
	    });

	    $('#changeProfileImage').on('click', function() {
	        $("#fileInput").trigger('click');
	    });

	    var imagesrc = $('#userPic').attr('src');
		function filePreview(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        reader.onload = function (e) {
		           // $('#signupForm + img').remove();
		            /*$('.userPic').html('<img src="'+e.target.result+'"/>');*/
		            $('#userPic').attr('src', e.target.result);
		        }
		        reader.readAsDataURL(input.files[0]);
		    }
		}
		$('body').on('change',"#fileInput", function () {
		    filePreview(this);
		});

		$('body').on('click',"#fileInput", function () {
		    $('#userPic').attr('src', imagesrc);
		});
	});
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script>
    $('select').selectpicker();
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjLgWug0GkYxSFTUKOvTnBGvTkg9amnD0&amp;libraries=places"></script>
         
<script type="text/javascript">
        google.maps.event.addDomListener(window, 'load', function () {
            var places = new google.maps.places.Autocomplete(document.getElementById('autocomplete_search'));
            google.maps.event.addListener(places, 'place_changed', function () {
                var place = places.getPlace();
                var address = place.formatted_address;
                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
                $("#source_lat").val(latitude);
                $("#source_long").val(longitude);
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/frontend/add_business.blade.php ENDPATH**/ ?>