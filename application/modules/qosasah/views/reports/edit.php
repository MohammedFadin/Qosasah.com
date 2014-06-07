<?php

$validation_errors = validation_errors();

if ($validation_errors) :
?>
<div class="alert alert-block alert-error fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<h4 class="alert-heading">Please fix the following errors:</h4>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;

if (isset($qosasah))
{
	$qosasah = (array) $qosasah;
}
$id = isset($qosasah['id']) ? $qosasah['id'] : '';

?>
<div class="admin-box">
	<h3>qosasah</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('snippet_post') ? 'error' : ''; ?>">
				<?php echo form_label('snippet'. lang('bf_form_label_required'), 'qosasah_snippet_post', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'qosasah_snippet_post', 'id' => 'qosasah_snippet_post', 'rows' => '5', 'cols' => '80', 'value' => set_value('qosasah_snippet_post', isset($qosasah['snippet_post']) ? $qosasah['snippet_post'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('snippet_post'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('qosasah_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/reports/qosasah', lang('qosasah_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Qosasah.Reports.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('qosasah_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('qosasah_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>