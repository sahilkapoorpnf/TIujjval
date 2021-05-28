<?php
$controller = class_basename(Route::current()->controller);
$currentAction = \Route::getCurrentRoute()->getActionName();
list($controller, $action) = explode('@', $currentAction);
$controller = preg_replace('/.*\\\/', '', $controller);
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php if (Auth::user()->user_image) { ?>
                    <img src="<?php echo URL::to('/') . '/' . Auth::user()->user_image; ?>" class="img-circle" alt="User Image">
                <?php } else { ?>
                    <img src="<?php echo e(asset('public/vendor/adminlte/dist/img/user2-160x160.jpg')); ?>" class="img-circle" alt="User Image">
                    <?php
                }
                ?>

            </div>
            <div class="pull-left info">
                <p><?php echo ucfirst(Auth::user()->first_name); ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>      
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION </li>
            <li class="treeview">
                <a href="#"><i class="fas fa-user"></i><span> User Management</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu"><li class="active"><a href="<?php echo e(url('admin/user')); ?>"><i class="fa fa-circle-o"></i> User </a></li></ul>
            </li>

            <li class="treeview">

              <a href="#"><i class="fas fa-user"></i><span>Group Management</span>
              <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
              <ul class="treeview-menu"><li class="active"><a href="<?php echo e(url('admin/group')); ?>"><i class="fa fa-circle-o"></i> Group </a></li></ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="fas fa-user"></i><span>Flower Management</span>
              <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
              <ul class="treeview-menu"><li class="active"><a href="<?php echo e(url('admin/flower')); ?>"><i class="fa fa-circle-o"></i> Flower </a></li></ul>
            </li>



            

            <li class="treeview">
                <a href="#"><i class="fas fa-gift"></i><span> Subscription Management</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li class="active"><a href="<?php echo e(url('admin/subscription')); ?>"><i class="fa fa-circle-o"></i> Subscription List </a></li>
                    <li class="active"><a href="<?php echo e(url('admin/user-subscription')); ?>"><i class="fa fa-circle-o"></i> User Subscription</a></li>
                    <li class="active"><a href="<?php echo e(url('admin/flowerSubs')); ?>"><i class="fa fa-circle-o"></i> Flower Subscription</a></li>
                </ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="fas fa-question"></i><span>FAQ Management</span>
              <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
              <ul class="treeview-menu"><li class="active"><a href="<?php echo e(url('admin/faq')); ?>"><i class="fa fa-circle-o"></i> FAQ List </a></li></ul>
            </li>

            <li class="treeview menu-open"><a href="#"><i class="fas fa-home"></i><span>Main Website Settings</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i>
              </span></a>

              



                <ul class="treeview-menu">
                    <li class=""><a href="<?php echo e(url('admin/social')); ?>"><i class="fa fa-circle-o"></i> Social Media </a></li>
                    <li class=""><a href="<?php echo e(url('admin/page')); ?>"><i class="fa fa-circle-o"></i> Pages </a></li>
                    <li class=""><a href="<?php echo e(url('admin/setting')); ?>"><i class="fa fa-circle-o"></i> Settings </a></li>
                    <li class=""><a href="<?php echo e(url('admin/banner')); ?>"><i class="fa fa-circle-o"></i> Banner </a></li>
                    <li class=""><a href="<?php echo e(url('admin/stripeinfo')); ?>"><i class="fa fa-circle-o"></i> Strip Payment Gateway </a></li>
                    <li class=""><a href="<?php echo e(url('admin/testimonials')); ?>"><i class="fa fa-circle-o"></i> Testimonials </a></li>
                    <!-- <li class=""><a href="<?php echo e(url('admin/mailtemplate')); ?>"><i class="fa fa-circle-o"></i> Mail Template </a></li>
                    -->                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/vendor/adminlte/partials/menu-item.blade.php ENDPATH**/ ?>