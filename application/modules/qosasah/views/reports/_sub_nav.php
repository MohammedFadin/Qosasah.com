<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/reports/qosasah') ?>" id="list"><?php echo lang('qosasah_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Qosasah.Reports.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/reports/qosasah/create') ?>" id="create_new"><?php echo lang('qosasah_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>