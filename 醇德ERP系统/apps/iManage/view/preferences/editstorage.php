<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script> 
<section class="content-header">
  <h1>
    入库设置
    <small>编辑入库类型</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> ERP系统</a></li>
    <li><a href="#">参数设置</a></li>
    <li class="active">入库设置</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <form  class='box box-primary form-validate' action='<?=$this->url("preferences/updatestorage")?>' id="login" method='post'>
    <div class="box-header with-border">
      <h3 class="box-title">请填写入库类型信息</h3>
      <div class="box-tools pull-right">
        <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
      </div>
    </div><!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="form-group">
            <label for="titlesss">名称设置</label>
            <input type="text" name="data[title]" id="title"  value="<?=$re['title']?>" class="form-control" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label for="titlesss">状态</label>
            <select name="data[status]" class="form-control">
              <option value="1" <?=$re['status']==1?"selected":''?> >正常</option>
              <option value="0" <?=$re['status']==0?"selected":''?> >禁用</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <input type="hidden" value="<?=!empty($re)?$re['id']:''?>" name="id">
      <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> 提交</button>
      <button class="btn btn-default" type="button" onclick="returnList()"><i class="fa fa-reply"></i> 返回</button>
    </div>
  </form>
</section>
<!-- /.content -->
<script>
  function returnList(){
    window.location.href="<?=$this->url('preferences/storage')?>";
  }
</script>
