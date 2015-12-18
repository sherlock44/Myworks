<section class="content-header">
<h1>
  账户信息
  <small>修改密码</small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> 采购平台</a></li>
  <li><a href="#">管理中心</a></li>
  <li class="active">个人信息</li>
</ol>
</section>
<!-- Main content -->
<section class="content">
  <form class="box box-primary form-validate" action='<?=$this->url("index/savePassword")?>' id="login" name="bb" method='post'>
    <div class="box-header with-border">
      <h3 class="box-title">修改密码</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div><!-- /.box-header -->
    <div class="box-body">
      <div class="row">
      <!-- left column -->
        <div class="col-md-6">
        <!-- general form elements -->
          <div class="form-group">
            <label for="oldpwd">原密码</label>
            <input type="password" name="oldpwd" id="oldpwd"  value="" class="form-control"
                               data-rule-required="true" data-rule-minlength="6" >
          </div>
          <div class="form-group">
            <label for="password">新密码</label>
            <input type="password" name="password" id="password" value="" class="form-control"
                               data-rule-required="true" data-rule-minlength="6" placeholder="新密码">
          </div>
          <div class="form-group">
            <label for="pwd">确认新密码</label>
            <input type="password" name="pwd" id="pwd" value="" class="form-control"  data-rule-required="true" data-rule-minlength="6" placeholder="确认新密码">
          </div>
		  
        </div>
		
       
		
		
      </div>
    </div>
    <div class="box-footer">
      <input type="hidden" value="<?= !empty($re) ? $re['id'] : '' ?>" name="id">
      <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> 提交修改</button>
    </div>
  </form>
</section>
<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>