    <div class="container-fluid text-right" style="padding-top:50px;" dir="rtl">
      <div class="col-md-8 col-md-offset-1">
        <ul class="breadcrumb">
          <li><a href="<?php echo site_url();?>">الرئيسية</a></li>
          <li><a href="#"><?php echo $snippet['name'];?></a></li>          
          <li class="active"><?php echo $snippet['title'];?></li>
        </ul>
          <div class="panel panel-default">
            <div class="panel-heading">
              <?php echo $snippet['title'];?>:
            </div>
            <div class="panel-body">
              <?php echo $snippet['description'];?>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">القصاصة البرمجية
            </div>
            <div class="panel-body">
              <div class="text-left" id="editor" style="height: 500px;">
<?php echo htmlspecialchars( $snippet['snippet'] );?>
              </div>
            </div>
          </div>
        </div>
      <div class="row">
        <div class="col-md-2">
          <div class="panel panel-default">
            <div class="panel-heading">معلومات القصاصة
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12 text-center">
                  <img src="<?php echo img_path();?>prog-icons/<?php echo mb_strtolower($snippet['name']);?>.png" 
                  class="" width="100" height="100">
                </div>
                <div class="col-md-12 text-center">
<hr>
                  <p> اللغة: <?php echo $snippet['name'];?> </p>
                  <p> تاريخ الإضافة : <?php echo $snippet['created_at'];?> </p>
                  <p> المصدر : <?php echo $snippet['url'];?> </p>                  
                  <p> العضو : <?php echo $snippet['username'];?> </p>
                  <hr>
                  <p><button class="btn btn-primary"> أعجبني ♥</button></p>
                  <p><a href="https://twitter.com/share?text=<?php echo $snippet['title'];?>&hashtags=برمجة,<?php echo $snippet['name'];?>" target="_blank" class="btn btn-primary">غرّد القصاصة</a></p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
      <div class="col-md-8 col-md-offset-1">
        <h4>التعليقات:</h4>
        <div id="disqus_thread"></div>
        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
      </div>
    </div>
<script type="text/javascript" src="<?php echo js_path();?>jquery.min.js"></script>    
<script src="<?php echo js_path();?>src-noconflict/theme-twilight.js"></script>    
<script src="<?php echo js_path();?>src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo js_path();?>src-noconflict/mode-php.js"></script>

<script>
    var editor = ace.edit( "editor" );
    editor.setTheme( "ace/theme/twilight" );
    editor.getSession().setUseWrapMode(true);
    editor.session.setMode({
      path : "ace/mode/<?php echo mb_strtolower($snippet['name']);?>",
      inline : true,
      pure : true
    })

  // switch( "<?php echo $snippet['category'];?>" ) {
  //   case "1":
  //         editor.session.setMode({
  //             path : "ace/mode/java",
  //             inline : true,
  //             pure : true
  //         });
  //         break;
  //   case "2":
  //         editor.session.setMode({
  //             path : "ace/mode/javascript",
  //             inline : true,
  //             pure : true
  //         });
  //         break;    
  //   case "3":
  //         editor.session.setMode({
  //             path : "ace/mode/php",
  //             inline : true,
  //             pure : true
  //         });
  //         break;                                  
  // }
</script>    
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = 'qsasah'; // required: replace example with your forum shortname
    var disqus_developer = 1; // this would set it to developer mode
    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>