<?php echo theme_view('_footer');?>
<?php echo theme_view('_header');?>
<?php echo isset($content) ? $content : Template::content();?>
<?php echo theme_view('login');?>
