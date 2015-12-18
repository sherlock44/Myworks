<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script> 
<section class="content-header">
  <h1>
    意向客户
    <small>添加意向客户</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
    <li><a href="#">客户管理</a></li>
    <li class="active">意向客户</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <form  class='box box-primary form-validate' action='<?=$this->url("user/insertcustomer")?>'  id="login" name="login" method='post'>
    <div class="box-header with-border">
      <h3 class="box-title">请填写意向客户信息</h3>
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
            <label for="titlesss">客户来源</label>
            <select name="data[source]"  class="form-control">
              <?
              foreach($sysconf['clientsource'] as $k=>$v){?>
              <option value="<?=$k?>"><?=$v?></option>
              <?}
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="name">公司名称</label>
            <input type="text" name="data[name]" id="name"  class="form-control valid" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label for="addr">负责人姓名</label>
            <input type="text" name="data[dutyname]" id="name"   class="form-control valid" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div> 
          <div class="form-group">
            <label for="mobile">负责人电话</label>
            <input type="text" name="data[mobile]" id="data[mobile]"   class="form-control valid" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div> 
          <div class="form-group">
            <label for="dutyemail">负责人邮箱</label>
            <input type="text" name="data[dutyemail]" id="data[dutyemail]"   class="form-control valid" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label >客户主营业务(产品渠道等)</label>
            <textarea class="form-control" name="data[intro]" rows="3"></textarea>
          </div>
        </div>
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="form-group">
            <label for="password">所属区域</label>
            <select name="data[proviceid]"  class="form-control" onchange="javascript:$('#cityid').html('');$('#areaid').html('');bindSelect('/index.php/iManage/area/getRegion?parentid='+this.value,'cityid');">
              <?foreach ($province as $key=>$val){?>
              <option value="<?=$val['id']?>"><?=$val['name']?></option>
              <?}?>
            </select>
            <br />
            <select id="cityid" name="data[cityid]"  class="form-control" onchange="javascript:$('#areaid').html('');bindSelect('/index.php/iManage/area/getRegion?parentid='+this.value,'areaid');">
              <option value="0">市</option>
            </select>
            <br />
            <select name="data[areaid]"  class="form-control" id="areaid">
              <option value="0">区/县</option>
            </select>
          </div>
          <div class="form-group">
            <label for="addr">公司地址</label>
            <input type="text" name="data[addr]" id="data[addr]"   class="form-control valid" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1"> 
          </div>
          <div class="form-group">
            <label for="type">客户类型</label>
            <select name="data[type]" class="form-control">
              <?foreach($usertype as $val){?>
              <option value="<?=$val['id']?>" ><?=$val['title']?></option>
              <?}?>
            </select>
          </div>
          <div class="form-group">
            <label for="type">意向类型</label>
            <select name="data[intention_type]" class="form-control">
              <?
              foreach($sysconf['intention_type'] as $k=>$v){?>
              <option value="<?=$k?>"><?=$v?></option>
              <?}?>
            </select>
          </div>
          <div class="form-group">
            <label >合作意向</label>
            <textarea class="form-control" name="data[intent]" rows="3"></textarea>
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
  window.location.href="<?=$this->url('user/customer')?>";
}
</script>
