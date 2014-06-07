		<?php foreach ($meta_fields as $field):?>
			<?php if ((isset($field['admin_only']) && $field['admin_only'] === TRUE && isset($current_user) && $current_user->role_id == 1)
						|| !isset($field['admin_only']) || $field['admin_only'] === FALSE): ?>
			<?php
			if (!isset($frontend_only) || ($frontend_only === TRUE && (!isset($field['frontend']) || $field['frontend'] === TRUE))):

				if ($field['form_detail']['type'] == 'dropdown'):

					echo form_dropdown($field['form_detail']['settings'], $field['form_detail']['options'], set_value($field['name'], isset($user->$field['name']) ? $user->$field['name'] : ''), $field['label']);


			elseif ($field['form_detail']['type'] == 'checkbox'): ?>

					<div class="form-group <?php echo iif( form_error($field['name']) , 'error'); ?>">
					<label class="control-label" for="<?php echo $field['name'] ?>"><?php echo $field['label'];?></label>
						<?php
						$form_method = 'form_' . $field['form_detail']['type'];
						$checked = (isset($user->$field['name']) && $field['form_detail']['value'] == set_value($field['name'], isset($user->$field['name']) ? $user->$field['name'] : '')) ? TRUE : FALSE;
						echo form_checkbox($field['form_detail']['settings'], $field['form_detail']['value'], $checked);
						?>
				</div>


			<?php elseif ($field['form_detail']['type'] == 'state_select' && is_callable('state_select')) : ?>

				<div class="form-group <?php echo iif( form_error($field['name']) , 'error'); ?>">
						<label class="control-label" for="<?php echo $field['name'] ?>"><?php echo lang('user_meta_state'); ?></label>
							<?php echo state_select(set_value($field['name'], isset($user->$field['name']) ? $user->$field['name'] : 'SC'), 'SC', 'US', $field['name'], 'form-control'); ?>
				</div>

				<?php elseif ($field['form_detail']['type'] == 'country_select' && is_callable('country_select')) : ?>

					<div class="form-group <?php echo iif( form_error('country') , 'error'); ?>">
						<label for="country"><?php echo lang('user_meta_country'); ?></label>
							<?php echo country_select(set_value($field['name'], isset($user->$field['name']) ? $user->$field['name'] : 'US'), 'US', 'country', 'form-control'); ?>
					</div>

				<?php else:


					$form_method = 'form_' . $field['form_detail']['type'];
					if (is_callable($form_method))
					{
						echo $form_method($field['form_detail']['settings'], set_value($field['name'], isset($user->$field['name']) ? $user->$field['name'] : ''), $field['label']);
					}


				endif;
			endif;
			?>
			<?php endif;?>
		<?php endforeach; ?>
