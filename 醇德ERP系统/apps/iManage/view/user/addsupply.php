<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script> 
<section class="content-header">
  <h1>
    供应商管理
    <small>添加供应商</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
    <li><a href="#">客户管理</a></li>
    <li class="active">供应商管理</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <form  class='box box-primary form-validate' action='<?=$this->url("user/insertsupply")?>'  id="login" name="login" method='post'>
    <div class="box-header with-border">
      <h3 class="box-title">请填写供应商信息</h3>
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
            <label for="titlesss">供应商名称</label>
            <input type="text" name="data[title]" id="title" value=""  class="form-control valid" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label for="name">供应商类型</label>
            <select name='data[type]' class="form-control valid">
              <?foreach($supplytype as $val){?>
              <option value="<?=$val['id']?>"><?=$val['title']?></option>
              <?}?>
            </select>
          </div>
          <div class="form-group">
            <label for="dutyemail">地址</label>
            <textarea  rows="3" name="data[address]" class="form-control"><?=!empty($re) ? $re['address']: ''?></textarea>
          </div>
          <div class="form-group">
            <label >状态</label>
            <select name='data[status]' class="form-control ">
              <option value='1' >正常</option>
              <option value='0' >冻结</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="form-group">
            <label for="addr">联系人</label>
            <input type="text" name="data[name]" id="name" value="" class="form-control" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div> 
          <div class="form-group">
            <label for="mobile">联系电话</label>
            <input type="text" name="data[mobile]" id="mobile" value="" class="form-control" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div> 
          <div class="form-group">
            <label >简介说明</label>
            <textarea  rows="3" name="data[remark]" class="form-control"><?=!empty($re) ? $re['remark']: ''?></textarea>
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
//返回列表
function returnList(){
  window.location.href="<?=$this->url('user/supply')?>";
}
</script>
