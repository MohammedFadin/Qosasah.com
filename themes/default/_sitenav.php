<div class="navbar navbar-fixed-top navbar-inverse">
      <div class="container" >
        <div class="navbar-header" >
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo site_url();?>"><?php if (class_exists('Settings_lib')) e(settings_item('site.title')); else echo 'Bonfire'; ?></a>
        </div>
        <div class="navbar-collapse collapse" >
          <ul class="nav navbar-nav">
            <li <?php echo check_class('home'); ?>>
              <a href="<?php echo site_url();?>">نظرة عامة&nbsp;<i class="fa fa-tasks"></i>&nbsp;</a>
            </li>
            <li <?php echo check_method('add'); ?>>
              <a href="<?php echo site_url('qosasah/add');?>"> إضافة كودة&nbsp;<i class="fa fa-pencil-square"></i></a>
            </li>
            <li <?php echo check_method('my_snippets'); ?>>
              <a href="<?php echo site_url('qosasah/my_snippets');?>">أكوادي الخاصة <i class="fa fa-flag"></i></a>
            </li>
            <li <?php echo check_method('my_favorite'); ?>>
              <a href="<?php echo site_url('qosasah/my_favorite');?>">مفضلتي <i class="fa fa-bookmark"></i></a>
            </li>
            <?php if ( isset($current_user) ):?>
            <li <?php echo check_method('profile'); ?>>
              <a href="<?php echo site_url('/users/profile'); ?>">ملف الشخصي <i class="fa fa-pencil-square"></i></a>
            </li>
            <li>
                  <a href="<?php echo site_url('/logout'); ?>">خروج <i class="fa fa-pencil-square"></i></a>
            </li>
            <?php endif;?>   
          </ul>
            <?php if (!isset($current_user)):?>
            <ul class="nav navbar-nav navbar-right">
            <li class="navbar-left">
                  <a href="<?php echo site_url('/login'); ?>"><i class="fa fa-pencil-square"></i>دخول</a>
            </li>
            <li>
                  <a href="<?php echo site_url('/register'); ?>"><i class="fa fa-pencil-square"></i>تسجيل</a>
            </li>
            <?php endif;?>               
            </ul>          
        </div>
        <!--/.navbar-collapse -->
      </div>
    </div>