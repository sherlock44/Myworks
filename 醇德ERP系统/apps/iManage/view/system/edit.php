<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script> 
<section class="content-header">
  <h1>
    账号管理
    <small>账号信息修改</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
    <li><a href="#">系统管理</a></li>
    <li class="active">账号管理</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
	<form  class='box box-primary form-validate' action='<?=$this->url("system/update")?>'  id="login" name="login" method='post'>
    <div class="box-header with-border">
      <h3 class="box-title">请填写账号信息</h3>
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
            <label for="username">账号名称</label>
            <input type="text" data-rule-minlength="1" readonly="readonly"  data-rule-required="true" class="form-control valid" value="<?=empty($re['name'])?0:$re['name']?>"  id="username" name="username">
          </div>
          <div class="form-group">
            <label for="address">公司职务</label>
            <input type="text" placeholder="公司职务" data-rule-minlength="1"  data-rule-required="true" class="form-control" value="<?=empty($re['jobpost'])?'':$re['jobpost']?>" id="address" name="data[jobpost]">
          </div>
          <div class="form-group">
            <label for="truename">真实姓名</label>
            <input type="text" name="data[truename]" id="truename" value="<?=empty($re['truename'])?'':$re['truename']?>" class="form-control" data-rule-required="true" data-rule-minlength="2">
          </div>
          <div class="form-group">
            <label for="mobile">电话号码</label>
            <input type="text" name="data[mobile]" id="mobile" value="<?=empty($re['mobile'])?'':$re['mobile']?>" class="form-control" data-rule-required="true" data-rule-minlength="2">
          </div>
          <div class="form-group">
            <label for="commname">角色</label>
            <select name="groupid" class="form-control">
              <? foreach($r as $k=>$v){?>
              <option  value="<?=$v['groupid']?>" <?if(isset($re['groupid']) && $re['groupid']==$v['groupid']){?>selected="true"<?}?> ><?=$v['title']?></option>
              <?} ?>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="form-group">
            <label for="password">密码</label>
            <input type="password" maxlength="20" name="password" id="password" value="" placeholder="请填写6-20位长度的密码" class="form-control" data-rule-required="false"  data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label for="pwd">确认密码</label>
            <input type="password" maxlength="20" name="pwd" id="pwd" value="" placeholder="请再次确认密码" class="form-control" data-rule-required="false" >
          </div>
          <div class="form-group">
            <label for="email">邮箱</label>
            <input type="text" name="data[email]" id="email" value="<?=empty($re['email'])?'':$re['email']?>" class="form-control" data-rule-required="true" >
          </div>
          <div class="form-group">
            <label for="qq">QQ</label>
            <input type="text" name="data[qq]" id="qq" value="<?=empty($re['qq'])?'':$re['qq']?>" class="form-control" data-rule-required="true" data-rule-minlength="2">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select name="status" id="status" class="form-control">
              <option value="1" <?if(isset($re['status']) && $re['status']==1){echo "selected";}?>>正常</option>
              <option value="0" <?if(isset($re['status']) && $re['status']==0){echo "selected";}?>>冻结</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <input type="hidden" name="id" value="<?=$re['id']?>">
      <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> 提交</button>
      <button class="btn btn-default" type="button" onclick="returnList()"><i class="fa fa-reply"></i> 返回</button>
    </div>
  </form>
</section>
<script>
	function returnList(){
      window.location.href='<?=$this->url("system/admin")?>';
    }
</script>