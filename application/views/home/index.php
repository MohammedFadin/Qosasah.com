<style type="text/css">
  .snipper{
        position: absolute;
    top: 0;
    right: 0;
    z-index: 1010;
    display: none;
    max-width: 276px;
    padding: 1px;
    text-align: right;
    white-space: normal;
  }
</style>
<div class="container" style="margin-top:40px;">
<div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-heading text-center">
              <h4><b>آخر القُصاصات البرمجية</b></h4>
            </div>
            <div class="panel-body">
            <?php foreach ($snippets['total_snippets'] as $snippet):?>
              <div class="row" id="<?php echo $snippet['id'];?>">
                <div class="snippet-row col-md-12" dir="rtl">
                  <div class="col-sm-7">
                  <p class="text-right"><a href="<?php echo site_url('qosasah/view/') . '/' . $snippet['id'];?>" onmouseover="showSnippet(this, <?php echo $snippet['id'];?>);" onmouseout="hideSnippet(this);"><?php echo ( strlen($snippet['title']) > 60 ) ? substr($snippet['title'], 0, 100) : $snippet['title'];?></a></p>
                  <p class="text-right"><small>اللغة: <span class="label label-success"><?php echo $snippet['language'];?></span> | المستخدم: <?php echo $snippet['username'];?> | تاريخ الإضافة: <?php echo $snippet['created_at'];?></small></p>
                  </div>
                  <div class="col-sm-5" id="<?php echo $snippet['id'];?>">
                  <br/>
                  <?php if ( isset($snippets['is_bookmarked']) AND in_array($snippet['id'], $snippets['is_bookmarked'])):?>
                    <a class="btn btn-success btn-sm btn-recommend pull-right">أضف للمفضلة <i class="fa fa-heart"></i></a>
                  <?php else:?>
                    <a class="btn btn-primary btn-sm btn-recommend pull-right">أضف للمفضلة <i class="fa fa-heart"></i></a>
                  <?php endif;?>
                    <a href="https://twitter.com/share?url=<?php echo site_url() . '/qosasah/view/' . $snippet['id'];?>&text=<?php echo $snippet['title'];?>&hashtags=برمجة,<?php echo $snippet['language'];?>" target="_blank" class="btn btn-sm btn-primary pull-right">غرّد القصاصة</a>
                  </div>
                  <hr class="invisible">
                </div>
              </div>
            <?php endforeach;?>
            </div>
          </div>
        </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading text-center">
              <b><h4><b>إحصائيات قُصاصة</b>
              </h4>
              </b>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12 text-center">chart</div>
              </div>
              <div class="row text-right">
                <div class="col-md-6">
                  <p>عدد المستخدمين : <?php echo $status['total_users'];?></p>
                </div>
                <div class="col-md-6">
                    <p>عدد القصاصات : <?php echo $status['total_snippets'];?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading text-center">
              <b><h4><b>أفضل القصاصات البرمجية</b>
              </h4>
              </b>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-condensed text-right" dir="rtl">
                    <tbody>
                      <?php foreach($snippets['top_snippets'] as $snippet):?>
                      <tr>
                        <td>
                          <div class="col-md-2"><span class="label label-default"><?php echo $snippet['language'];?></div>&nbsp;<a href="<?php echo site_url().'/qosasah/view/'. $snippet['id'];?>"><?php echo $snippet['title'];?></a>
                        </td>
                      </tr>
                    <?php endforeach;?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading text-center">
              <b><h4><b>أفضل المشاركين</b>
              </h4>
              </b>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-condensed text-right" dir="rtl">
                    <thead>
                      <tr>
                        <th class="text-right">المشارك</th>
                        <th class="text-right">عدد الأكواد</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($snippets['top_users'] as $user) :?>
                      <tr>
                        <td>
                          <a href="#"><?php echo $user['username'];?></a>
                        </td>
                        <td><?php echo $user['total_posted_snippets'];?></td>
                      </tr>
                    <?php endforeach;?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- end of columns-->

      </div>
      <div class="row text-center">
      <div class="col-md-12">
        <?php echo $this->pagination->create_links();?>
      </div>
    </div>
    </div>
<script type="text/javascript" src="<?php echo js_path();?>jquery.min.js"></script>    
<script src="<?php echo js_path();?>src-noconflict/theme-twilight.js"></script>    
<script src="<?php echo js_path();?>src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo js_path();?>src-noconflict/mode-php.js"></script>    
<script type="text/javascript">

function showSnippet (element, snippet_id) 
{

  $(element).popover({title: 'قصاصة',
  html:true,
  content:'<div class="text-left" id="editor"></div>',
  placement: 'bottom',
  template: '<div class="snipper"><div class="popover-content"></div></div>'}).popover('show');

  $('#editor').css('height', '300px');
  $('#editor').css('width', '500px');

  var editor = ace.edit( "editor" );
  editor.setTheme( "ace/theme/twilight" );
  editor.getSession().setUseWrapMode(true);
  editor.getSession().setUseWorker(false);
  editor.session.setMode({
    path : "ace/mode/php",
    inline : true,
    pure : true
  });

  $.ajax
  ({
    url: "<?php echo site_url();?>/qosasah/get_snippet_ajaxed/"+snippet_id,
    type: "GET",
    success: function(data)
    {
        editor.getSession().setValue(data);
    },
    error: function(data)
    {
      editor.getSession().setValue('حدثت مشكلة');
    }
  });




}

function hideSnippet (snippet) 
{
  $(snippet).popover('destroy');
}


$(document).ready(function()
{





  $('.btn-recommend').click(function(event)
  {
    event.preventDefault();
    $bookmark_button = $(this);

       $.ajax
       ({
        url: "<?php echo site_url();?>/qosasah/bookmark/"+$bookmark_button.parent().attr('id'),
        type: "GET",
        success: function(data)
        {

          switch ( data )
          {
            case "bookmarked":
              $bookmark_button.removeClass('btn-primary');
              $bookmark_button.addClass('btn-success');
              break;
            case "unbookmarked":
              $bookmark_button.removeClass('btn-success');
              $bookmark_button.addClass('btn-primary');
            break;
          }

        },
        error: function(data)
        {
          $bookmark_button.removeClass('btn-primary');
          $bookmark_button.removeClass('btn-success');
          $bookmark_button.addClass('btn-danger');
        }
      });
  }); 







});


</script>