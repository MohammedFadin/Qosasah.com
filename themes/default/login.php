<?php echo theme_view('_header'); ?>


    <?php echo theme_view('_sitenav'); ?>

    <?php
        echo isset($content) ? $content : Template::content();
    ?>

<?php echo theme_view('_footer'); ?>