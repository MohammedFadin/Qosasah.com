<style type="text/css" media="screen">
    #editor { 
        padding-top: 500px;
    }
</style>
<div class="container-fluid well" style="padding-top:50px; padding-bottom:10%" dir="rtl">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title text-right">إضافة قصاصة برمجية</h3>
            </div>
            <div class="panel-body">
              <?php if (validation_errors()) :?>
                <div class="row-fluid">
                  <div class="col-md-12">
                    <div class="alert alert-success">
                      <h3 class="text-center">حدث خطأ!</h3> 
                      <?php echo validation_errors(); ?>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
              <?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal'));?>
                <fieldset class="text-right">
                  <div class="form-group">
                    <label for="snippet_title" class="col-sm-2">عنوان القصاصة</label>
                    <div class="col-sm-10">
                      <input type="text" name="snippet_title" value="<?php echo set_value('snippet_title');?>" class="form-control text-right">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="snippet_desc" class="col-sm-2">شرح مفصل</label>
                    <div class="col-sm-10">
                      <textarea name="snippet_desc" row="3" value="<?php echo set_value('snippet_desc');?>" class="form-control text-right"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="language" class="col-sm-2">اللغة البرمجية المستخدمة</label>
                    <div class="col-sm-10">
                      <select name="snippet_lang" id="language" onchange="switchLang();" class="form-control" dir="ltr">
                      <?php foreach ($categories as $key):?>
                        <option value="<?php echo $key['id'];?>"><?php echo $key['name'];?></option>
                      <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="editor" class="col-sm-2">(Snippet)القصاصة البرمجية</label>
                    <input type="hidden" name="snippet_data" style="display: none;" value="<?php echo set_value('snippet_data');?>">
                    <div class="col-sm-10 text-left">
                    <div id="editor" style="height: 500px;"><?php echo set_value('snippet_data');?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="snippet_url" class="col-sm-2">رابط</label>
                    <div class="col-sm-10">
                      <input type="text" name="snippet_url" value="<?php echo set_value('snippet_url');?>" class="form-control text-left required">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2">حالة القصاصة</label>                  
                    <div class="col-sm-10">
                        <input type="radio" name="snippet_type" value="0" checked>عام</label>
                        <input type="radio" name="snippet_type" value="1">خاص</label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="col-sm-10 col-sm-offset-7">
                        <button class="btn btn-success" type="submit" name="snippet_create" id="add">إضافة القصاصة</button>
                    </div>
                  </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
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
      path : "ace/mode/java",
      inline : true,
      pure : true
    })

   var input = $('input[name="snippet_data"]');
        editor.getSession().on("change", function () {
        input.val(editor.getSession().getValue());
    });

    function switchLang () {
        var langInput = $( '#language' ).val();
        switch( langInput ) {
          case "1":
                editor.session.setMode({
                    path : "ace/mode/java",
                    inline : true,
                    pure : true
                });
                break;
          case "2":
                editor.session.setMode({
                    path : "ace/mode/php",
                    inline : true,
                    pure : true
                });
                break;    
          case "3":
                editor.session.setMode({
                    path : "ace/mode/javascript",
                    inline : true,
                    pure : true
                });
                break;                                  
        }
    }
</script>