<?php
  use App\Social;
  use App\Setting;
  $socialmedia = Social::where('status', "1")->get();
  $address = Setting::where('id', '1')->first();
  $contact1 = Setting::where('id', '2')->first();
  $contact2 = Setting::where('id', '3')->first();
  $email = Setting::where('id', '4')->first();
  $email2 = Setting::where('id', '5')->first();
  $email3 = Setting::where('id', '6')->first();
?>
<footer class="footer">
  <div class="main-footer">
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-6 col-md-5 col-lg-5">
          <div class="footer-links Contact-info">
            <h4>Contact</h4>
            <ul class="list-unstyled">
              <li><span class="glyph-icon flaticon-marker"></span><a href="" target="_blank"><?php echo $address->description;?></a></li>

              <!-- <li><span class="glyph-icon flaticon-phone"></span><a href="tel:<?php echo $contact1->description;?>"><?php echo $contact1->description;?></a><a href="tel:<?php echo $contact2->description;?>"><?php echo $contact2->description;?></a></li> -->
              
              <li><span class="glyph-icon flaticon-mail"></span><a href="mailto:<?php echo $email3->description;?>"><?php echo $email3->description;?></a>
              <a href="mailto:<?php echo $email2->description;?>"><?php echo $email2->description;?></a>
              <p>To transfer your large group with manual data, please email us here, Loadus will love to automate you.</p>
              </li>

              <li><span class="glyph-icon flaticon-mail"></span><a href="mailto:<?php echo $email->description;?>"><?php echo $email->description;?></a>
              <p>To partner with Loadus, please email us here, we would love to collab.</p>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 col-lg-4">
          <div class="footer-links quick-links">
            <h4>Links</h4>
            <ul>
              <li><a href="<?php echo e(url('home')); ?>">Home</a></li>
              <li><a href="<?php echo e(url('about-us')); ?>">About Loadus</a></li>
              <li><a href="<?php echo e(url('Faq')); ?>">Loadus FAQ</a></li>
              <li><a href="<?php echo e(url('contact-us')); ?>">Contact Us</a></li>
              <li><a href="<?php echo e(url('terms-condition')); ?>">Terms And Condition</a></li>
              <li><a href="<?php echo e(url('privacy-policy')); ?>">Privacy Policy</a></li>
            </ul>
          </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-3">
          <div class="footer-links socail-links clearfix">
            <h4>Social Media</h4>
            <?php $__currentLoopData = $socialmedia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $socials): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <a href="<?php echo e($socials->link); ?>" class="" target="_blank"><i class="<?php echo e($socials->icon); ?>" aria-hidden="true"></i></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <!-- <a href="" class="fb" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="" class="twit" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></i></a>
            <a href="" class="link" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a> -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="copyright">
    <div class="container">
      Copyright © <?php echo date('Y');?> Loadus | All Rights Reserved
    </div>
  </div>
</footer>
<!--end footer  --><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/layouts/footer.blade.php ENDPATH**/ ?>