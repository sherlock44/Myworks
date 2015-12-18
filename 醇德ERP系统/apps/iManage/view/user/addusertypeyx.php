<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script> 
<section class="content-header">
  <h1>
    意向客户类型
    <small>添加意向客户类型</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
    <li><a href="#">参数设置</a></li>
    <li class="active">意向客户类型</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <form  class='box box-primary form-validate' action='<?=$this->url("user/insertusertypeyx")?>'  id="login" name="login" method='post'>
    <div class="box-header with-border">
      <h3 class="box-title">请填写意向客户类型信息</h3>
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
            <label for="titlesss">名称</label>
            <input type="text" name="data[title]" id="title"   class="form-control valid" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label for="titlesss">简介说明</label>
            <textarea  rows="3" name="data[remark]" class="form-control valid"><?=!empty($re) ? $re['remark']: ''?></textarea> 
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
    window.location.href="<?=$this->url('user/usertypeyx')?>";
  }
</script> 
  
