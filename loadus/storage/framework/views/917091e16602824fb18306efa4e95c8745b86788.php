<?php if($message = Session::get('success')): ?>

<script>
    PNotify.success({
            title: 'Success!',
            delay: 2500,
            text: '<?php echo e($message); ?>'
          });
</script>
<?php endif; ?>


<?php if($message = Session::get('error')): ?>
<script>
    PNotify.error({
            title: 'Error!',
            delay: 2500,
            text: '<?php echo e($message); ?>'
          });
</script>

<?php endif; ?>


<?php if($message = Session::get('warning')): ?>
<div class="alert alert-warning alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>	
    <i class="icon fa fa-warning"></i>
    <strong><?php echo e($message); ?></strong>
</div>
<?php endif; ?>


<?php if($message = Session::get('info')): ?>
<div class="alert alert-info alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>	
    <strong><?php echo e($message); ?></strong>
</div>
<?php endif; ?>



<?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/message.blade.php ENDPATH**/ ?>