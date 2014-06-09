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
            <?php foreach ($snippets as $snippet):?>
              <div class="row">
                <div class="snippet-row col-md-12" dir="rtl">
                  <div class="col-sm-7">
                  <p class="text-right"><a href="<?php echo site_url('qosasah/view/') . '/' . $snippet['id'];?>" onmouseover="showSnippet(this);" onmouseout="hideSnippet(this);"><?php echo ( strlen($snippet['title']) > 60 ) ? substr($snippet['title'], 0, 60) : $snippet['title'];?></a></p>
                  <p class="text-right">اللغة: <span class="label label-success"><?php echo $snippet['language'];?></span> | المستخدم: <?php echo $snippet['username'];?> | تاريخ الإضافة: <?php echo $snippet['created_at'];?></p>
                  </div>
                  <div class="col-sm-5" id="<?php echo $snippet['id'];?>">
                  <br/>
                   <a class="btn btn-primary btn-sm btn-recommend pull-right">أضف للمفضلة <i class="fa fa-heart"></i></a><a href="https://twitter.com/share?text=<?php echo $snippet['title'];?>&hashtags=برمجة,<?php echo $snippet['language'];?>" target="_blank" class="btn btn-sm btn-primary pull-right">غرّد القصاصة</a>
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
                    <thead>
                      <tr>
                        <th class="text-right">قصاصة</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <a href="#"><span class="label label-default">python</span> كود لقراءة الملفات</a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <a href="#"><span class="label label-default">python</span> كود لقراءة الملفات</a>
                        </td>
                      </tr>
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
                      <tr>
                        <td>
                          <a href="#">Mohammed Fadin</a>
                        </td>
                        <td>٤١</td>
                      </tr>
                      <tr>
                        <td>
                          <a href="#">SobiaLab</a>
                        </td>
                        <td>٣٣</td>
                      </tr>
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
        <ul class="pagination pagination-right">
          <li>
            <a href="#">أمام</a>
          </li>
          <li class="active">
            <a>١</a>
          </li>
          <li>
            <a href="#">٢</a>
          </li>
          <li>
            <a>٣</a>
          </li>
          <li>
            <a href="#">٤</a>
          </li>
          <li>
            <a href="#">سابق</a>
          </li>
        </ul>
      </div>
    </div>
    </div>
<script type="text/javascript" src="<?php echo js_path();?>jquery.min.js"></script>    
<script src="<?php echo js_path();?>src-noconflict/theme-twilight.js"></script>    
<script src="<?php echo js_path();?>src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo js_path();?>src-noconflict/mode-php.js"></script>    
<script type="text/javascript">

function showSnippet (snippet) 
{
  $(snippet).popover({title: 'قصاصة',
  html:true,
  content:'<div id="editor"></div>',
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
    pure : false
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
    $btn = $(this);
    if ( $btn.hasClass('btn-primary') ) // didnt vote yet
    {
       $.ajax
       ({
        url: "<?php echo site_url();?>/qosasah/add_bookmark/"+$btn.parent().attr('id'),
        type: "GET",
        success: function(data)
        {
          alert("good");
        },
        error: function(data)
        {
          alert("fail" + data);
        }
      });
    }
    else
    {
       $.ajax
       ({
        url: "<?php echo site_url();?>/qosasah/remove_bookmark/"+$btn.parent().attr('id'),
        type: "GET",
        data: { id : $btn.parent().attr('id') },
        success: function(data)
        {
          alert("good");
        },
        error: function(data)
        {
          alert("fail" + data);
        }
      });      
    }

  });  
});


</script>