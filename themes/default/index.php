<?php echo theme_view('_header'); ?>


    <?php echo theme_view('_sitenav'); ?>

    <?php
        // echo Template::message();
        echo isset($content) ? $content : Template::content();
    ?>
    <hr class="invisible">

<?php echo theme_view('_footer'); ?>