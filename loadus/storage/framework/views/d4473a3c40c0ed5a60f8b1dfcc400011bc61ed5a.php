<?php $__env->startSection('title', "$title"); ?>

<?php $__env->startSection('content_header'); ?>

<h1><?php echo e($title); ?></h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#"><?php echo e($title); ?></a></li>    
</ol>
<div class="clearfix cbutton">
    <div class="pull-right">
        <a href="<?php echo e(url('/admin/sub-categories/'.$id)); ?>"><button class="btn btn-success btn-flat">Back</button></a>
    </div> 
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
?>
<div class="box box-success color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo e($title); ?> </h3>

    </div>
    <div class="box-body">
        <form method="post" enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>

            
        <div class="box-body">

            <div class=" col-md-12">
                <div class="form-group">
                    <label>Title</label>                        
                    <?php echo Form::text('title', isset($data->title) ? $data->title : Input::get('title'), array('class' => 'form-control','required'=>true, 'placeholder' => 'Title')); ?>
                </div>
            </div>


            <div class=" col-md-12">
                <div class="form-group">
                    <label>Image</label> 
                    <input type="file" name="image" required class="form-control" style="padding: 0px">
                </div>
            </div>

            
            <div class="form-group col-md-12">
                <label>Status</label>
                <?php
                $select = isset($data->status) ? $data->status : Input::get('status');
                $status = ['1' => 'Active', '0' => 'In-Active'];
                echo Form::select('status', $status, $select, ['class' => 'form-control','required'=>true]);
                ?>
            </div>

        </div>

        <div class="box-footer">
            <button type="submit" class="btn btn-success btn-flat"><?php echo isset($data->id) ? 'Update' : 'Submit' ?></button>
        </div>
        </form>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/admin/subcategories/create.blade.php ENDPATH**/ ?>