<?php $__env->startSection('body_class', 'login-page'); ?>

<?php $__env->startSection('body'); ?>
<div class="login-box">
    <div class="login-logo">
        <!--<a href="<?php echo e(url(config('adminlte.dashboard_url', 'home'))); ?>"><?php echo config('adminlte.logo', '<b>Admin</b>LTE'); ?></a>-->
        <img src="<?php echo e(asset('public/frontend')); ?>/img/logo.png" style="margin-bottom:22px">
        <a href="<?php echo e(url(config('adminlte.dashboard_url', 'home'))); ?>"> <b>LOGIN</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <?php if(session('success')): ?>
        <div class="alert alert-success" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?> 
        
        <?php if(session('error')): ?>
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <?php echo e(session('error')); ?>

        </div>
        <?php endif; ?> 
        <p class="login-box-msg"><?php echo e(trans('adminlte::adminlte.login_message')); ?></p>
        <form action="<?php echo e(url('login_req')); ?>" method="post" autocomplete="off" id="login">
            <?php echo csrf_field(); ?>


            <div class="form-group has-feedback <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>"
                       placeholder="<?php echo e(trans('adminlte::adminlte.email')); ?>">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <?php if($errors->has('email')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('email')); ?></strong>
                </span>
                <?php endif; ?>
            </div>
            <div class="form-group has-feedback <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
                <input type="password" name="password" id="password" class="form-control"
                       placeholder="<?php echo e(trans('adminlte::adminlte.password')); ?>">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <?php if($errors->has('password')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('password')); ?></strong>
                </span>
                <?php endif; ?>
            </div>

            
            <div class="clearfix"></div>
            <hr>

            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember"> <?php echo e(trans('adminlte::adminlte.remember_me')); ?>

                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit"   class="btn btn-primary btn-block btn-flat"><?php echo e(trans('adminlte::adminlte.sign_in')); ?></button>
                </div>
                <!-- /.col -->
            </div>

        </form>
        
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('adminlte_js'); ?>
<script src="<?php echo e(asset('public/vendor/adminlte/plugins/iCheck/icheck.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/vendor/adminlte/dist/js/sha256.js')); ?>"></script>
<script src="<?php echo URL::to('public/vendor/adminlte/dist/js/validation.js'); ?>"></script>

<script>
                        $(function () {
                            $('input').iCheck({
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%' // optional
                            });
                        });
</script>

<script type="text/javascript">
    
    
    $('#login').on('click').validate({
        rules: {
            email: {
                required: true,
                email: true,
                isemail: true,
            },
            password: {
                required: true,
            },
        }, messages: {
            email: {
                //required: "Email ID must be filled.",
//                email: "Email ID is incorrect.",
                isemail: "Email ID is incorrect.",
            },
//            password: {
//                required: "Password must be filled.",
//            }
        },
    });
    $.validator.addMethod("isemail", function (value) {
        return /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i.test(value)
    });
</script>
<?php echo $__env->yieldContent('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>