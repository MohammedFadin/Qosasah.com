<?php if (!isset($show) || $show==true) : ?>
<footer>
    <hr class="invisible">
    <div class="container">
        <p style class="text-center"> <a href="http://twitter.com/mohammedfadin" target="_blank" style="text-decoration: none; color:black;">@ Made in 2 days with coffee by Mohammed Fadin</a></p>        
    </div>
</footer>
<?php endif; ?>

<div id="debug"></div>
<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
<script type="text/javascript" src="<?php echo js_path();?>jquery.min.js"></script>
<script type="text/javascript" src="<?php echo js_path();?>bootstrap.min.js"></script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<!-- This would be a good place to use a CDN version of jQueryUI if needed -->
<?php echo Assets::js(); ?>
<script>
$(function () { $("[data-toggle='tooltip']").tooltip(); });
</script>
</body>
</html>