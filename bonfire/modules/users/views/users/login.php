<?php
	$site_open = $this->settings_lib->item('auth.allow_register');
?>
    <div class="container-fluid well" style="padding-top:40px;">
	<?php if (validation_errors()) :?>
	<div class="row-fluid">
		<div class="span12">
			<div class="alert alert-error fade in">
			  <a data-dismiss="alert" class="close">&times;</a>
				<?php echo validation_errors(); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>    
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title text-center">تسجيل الدخول</h3>
            </div>
            <div class="panel-body">
            	<?php echo Template::message();?>
			<?php echo form_open(LOGIN_URL, array('autocomplete' => 'off')); ?>
                <fieldset class="text-right">
                  <div class="form-group">
                    <label for="email">بريدك الإلكتروني</label>
                    <input class="form-control text-right" id="email" name="login" id="login_value" value="<?php echo set_value('login'); ?>" placeholder="<?php echo $this->settings_lib->item('auth.login_type') == 'both' ? lang('bf_username') .'/'. lang('bf_email') : ucwords($this->settings_lib->item('auth.login_type')) ?>" />
                  </div>
                  <div class="form-group">
                    <label for="email">كلمة المرور</label>                    
                    <input class="form-control text-right" type="password" name="password" value="" placeholder="<?php echo lang('bf_password'); ?>">
                  </div>
                  <div class="checkbox">
                  	<?php if ($this->settings_lib->item('auth.allow_remember')) : ?>
								<div class="control-group">
									<div class="controls">
										<label class="checkbox" for="remember_me">
											<input type="checkbox" name="remember_me" id="remember_me" value="1" tabindex="3" />
											<span class="inline-help"><?php echo lang('us_remember_note'); ?></span>
										</label>
									</div>
								</div>
					<?php endif; ?>
                  </div>
                  <button class="btn btn-success" type="submit" name="log-me-in" id="login">تسجيل الدخول</button>
                </fieldset>
                <div class="checkbox">
                  <p>
                    <a href="<?php echo site_url();?>/forgot_password">نسيت كلمة المرور</a>
                  </p>
                  <?php if ( $this->settings_lib->item('auth.user_activation_method') == 1 ) : ?>
                  <p>
                    <a href="<?php echo site_url();?>/resend_activation">إعادة إرسال كود التفعيل</a>
                  </p>
              		<?php endif;?>
				</div>
		    <?php echo form_close();?>
            </div>
          </div>
        </div>
      </div>
      <hr class="invisible">
    </div>