<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script> 
<section class="content-header">
  <h1>
    系统管理
    <small>smtp设置</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
    <li><a href="#">系统管理</a></li>
    <li class="active">smtp设置</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <form  class='box box-primary form-validate' action='<?=$this->url("system/setting_smtp")?>'  id="login" name="login" method='post'>
    <div class="box-header with-border">
      <h3 class="box-title">请填写smtp设置信息</h3>
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
            <label for="smtpaddress">邮件服务器地址</label>
            <input type="text" name="data[smtpaddress]" id="smtpaddress" value="<?=!empty($re)?$re[4]['value']:''?>" class="form-control valid"  data-rule-required="true" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label for="port">服务器端口</label>
            <input type="text" name="data[port]" id="port" value="<?=$re[5]['value']?>" class="form-control valid" data-rule-required="true" data-rule-number="true" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label for="sendaccount">服务器邮箱</label>
            <input type="text" name="data[sendaccount]" id="sendaccount" value="<?=$re[6]['value']?>" class="form-control valid" data-rule-required="true" data-rule-email="true" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label for="emailpwd">邮箱密码</label>
            <input type="password" name="data[emailpwd]" id="returnaddress" value="<?=$re[8]['value']?>" class="form-control valid" data-rule-required="true" data-rule-minlength="6">
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> 提交</button>
    </div>
  </form>
</section>
<!-- /.content -->
