    <div class="container-fluid text-right" style="padding-top:50px;" dir="rtl">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4>مفضلتي</h4>
            </div>
            <div class="panel-body">
              <?php foreach ($snippets as $snippet):?>
              <div class="row">
                <div class="snippet-row col-md-12">
                  <p class="text-right"><a href="<?php echo site_url().'/qosasah/view/'.$snippet['id'];?>"><?php echo $snippet['title'];?></a></p>
                  <p class="text-right"><small>اللغة: <span class="label label-success"><?php echo $snippet['language'];?></span> | المستخدم: <a href="#"><?php echo $snippet['username'];?></a> | تاريخ الإضافة: <?php echo $snippet['created_at'];?></small></p>
                  <a class="btn btn-default btn-sm pull-left"><i class="fa fa-twitter"></i></a>
                  <a class="btn btn-default btn-sm pull-left">تعديل</a>
                  <a class="btn btn-default btn-sm pull-left">حذف</a>
                </div>
              </div>
              <?php echo $snippet == end($snippets)? '' : '<hr>';?>
            <?php endforeach;?>
            </div>
          </div>
        </div>
      </div>
    </div>