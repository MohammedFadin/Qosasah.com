    <div class="container-fluid text-right" style="padding-top:50px; padding-bottom:10%">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="panel panel-default">
            <div class="panel-heading">
              <b>قصاصاتي المضافة</b>
            </div><?php var_dump($snippets);?>
            <div class="panel-body">
            <?php foreach ($snippets as $snippet):?>
              <div class="row">
                <div class="snippet-row col-md-12">
                  <p class="text-right"><a href="<?php echo $snippet['id'];?>"><?php echo $snippet['title'];?></a></p>
                  <p class="text-right"><small>اللغة: <span class="label label-success"><?php echo $snippet['name'];?></span> | تاريخ الإضافة: <?php echo $snippet['created_at'];?></small></p>
                  <a class="btn btn-default btn-sm pull-left"><i class="fa fa-twitter"></i></a>
                  <a class="btn btn-default btn-sm pull-left">تعديل</a>
                  <a class="btn btn-default btn-sm pull-left">حذف</a>
                </div>
              </div>
              <hr>
            <?php endforeach;?>
            </div>
          </div>
        </div>
      </div>
    </div>