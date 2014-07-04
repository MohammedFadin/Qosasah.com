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
              <a href="<?php echo site_url();?>"><i class="fa fa-tasks"></i>&nbsp;نظرة عامة&nbsp;</a>
            </li>
            <li <?php echo check_method('add'); ?>>
              <a href="#about"><i class="fa fa-pencil-square"></i> إضافة كود</a>
            </li>
            <li <?php echo check_method('mylist'); ?>>
              <a href="#contact"><i class="fa fa-flag"></i> أكوادي الخاصة</a>
            </li>
            <li <?php echo check_method('mybookmark'); ?>>
              <a href="#contact">مفضلتي<i class="fa fa-bookmark"></i></a>
            </li>
            <?php if ( isset($current_user) ):?>
            <li <?php echo check_method('profile'); ?>>
              <a href="<?php echo site_url('/users/profile'); ?>"><i class="fa fa-pencil-square"></i> ملف الشخصي</a>
            </li>
            <li>
                  <a href="<?php echo site_url('/users/logout'); ?>"><i class="fa fa-pencil-square"></i>خروج</a>
            </li>
            <?php endif;?>               
          </ul>
          <?php if ( !isset($current_user) ):?>
          <?php echo form_open(LOGIN_URL, array('class'=>'navbar-form navbar-left', 'dir' => 'rtl','autocomplete' => 'off'));?>
            <div class="form-group">
              <input type="text" placeholder="بريدك الإلكتروني" class="form-control hidden-sm input-sm" name="login" value="">            
            </div>
            <div class="form-group">
              <input type="password" placeholder="كلمة المرور" class="form-control hidden-sm input-sm" name="password" value="">
            </div>
            <label class="checkbox" for="remember_me">
                        <input type="checkbox" name="remember_me" id="remember_me" value="1" tabindex="3" />
            </label>
            <button type="submit" name="log-me-in" class="btn btn-primary btn-sm">دخول</button>
            <?php echo form_close();?>
      <?php endif;?>
        </div>
        <!--/.navbar-collapse -->
      </div>
    </div>