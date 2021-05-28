<?php $__env->startSection('title', "$title"); ?>

<?php $__env->startSection('content_header'); ?>
<?php //echo ActionButton(1); ?>
<h1><?php echo e($title); ?></h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#"><?php echo e($title); ?></a></li>    
</ol>
<?php //echo CreateButton(); ?>

<div class="clearfix cbutton">
    <div class="pull-right">
        <a href="<?php echo e(url('admin/categories/add')); ?>"><button class="btn btn-success btn-flat" data-toggle="tooltip" title="" data-original-title="Create Page">Create Categories</button></a>
    </div> 
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div id="success"></div>
<div id="failed"></div>

<div class="box box-success color-palette-box">

    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo e($title); ?></h3>
        <!--<button class="btn btn-success btn-flat pull-right">Add </button>-->
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $a=1; ?>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($a); ?></td>
                    <td><?php echo e($category->title); ?></td>
                    <td><?php if($category->status=='1'): ?> Active <?php else: ?> Inactive <?php endif; ?></td>
                    <td><?php echo e($category->created_at); ?></td>
                    <td>
                        <a href="<?php echo e(url('admin/sub-categories/'.$category->id)); ?>" class="btn btn-primary">Sub Categories</a>
                        <a href="<?php echo e(url('admin/categories/edit/'.$category->id)); ?>" class="btn btn-success">Edit</a>
                        <a href="<?php echo e(url('admin/categories/delete/'.$category->id)); ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                    <?php $a++; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php echo $categories->render(); ?>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/admin/categories/index.blade.php ENDPATH**/ ?>