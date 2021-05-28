
<?php echo $__env->make('layouts.header_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body >
<?php if(Session::has('message')): ?>
<div class="alert <?php echo e(Session::get('alert-class', 'alert-info')); ?> alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<?php echo e(Session::get('message')); ?>

</div>
<?php endif; ?>	
<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldPushContent('script'); ?>
</body>
</html><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/layouts/base.blade.php ENDPATH**/ ?>