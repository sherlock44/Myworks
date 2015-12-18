<section class="content-header">
<h1>
  账户信息
  <small>编辑帐号信息</small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> 采购平台</a></li>
  <li><a href="#">管理中心</a></li>
  <li class="active">个人信息</li>
</ol>
</section>
<!-- Main content -->
<section class="content">
  <form class="box box-primary form-validate" action='<?=$this->url("system/update")?>' id="login" name="bb" method='post'>
    <div class="box-header with-border">
      <h3 class="box-title">账号信息修改</h3>
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
            <label for="username">帐号</label>
            <input type="text" name="data[username]" id="username" readonly="readonly" value="<?=$re['username']?>" class="form-control"
                               data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1" >
          </div>
          <div class="form-group">
            <label for="address">地址</label>
            <input type="text" name="data[address]" id="address" value="<?=$re['address']?>" class="form-control"
                               data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写地址">
          </div>
          <div class="form-group">
            <label for="commname">公司名称</label>
            <input type="text" name="data[commname]" id="commname" value="<?=$re['commname']?>" class="form-control"  data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写公司名称">
          </div>
          <div class="form-group">
            <label for="commtel">公司电话</label>
            <input type="text" name="data[commtel]" id="commtel" value="<?=$re['commtel']?>" class="form-control"
                               data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写公司电话">
          </div>
          <div class="form-group">
            <label for="comaddress">公司地址</label>
            <input type="text" name="data[comaddress]" id="comaddress" value="<?=$re['comaddress']?>" class="form-control"
                               data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写公司地址">
          </div>
          <div class="form-group">
            <label for="truename">负责人</label>
            <input type="text" name="data[truename]" id="truename" value="<?=$re['truename']?>" class="form-control"
                               data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写负责人">
          </div>
          <div class="form-group">
            <label for="mobile">负责人电话</label>
            <input type="text" name="data[mobile]" id="mobile" value="<?=$re['mobile']?>" class="form-control"
                               data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写负责人电话">
          </div>
          <div class="form-group">
            <label for="email">负责人邮箱</label>
            <input type="text" name="data[email]" id="email" value="<?=$re['email']?>" class="form-control"
                               data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写负责人邮箱">
          </div>
          <div class="form-group">
            <label for="proname">业务联系人</label>
            <input type="text" name="data[proname]" id="proname" value="<?=$re['proname']?>" class="form-control"
                               data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写业务联系人">
          </div>
          <div class="form-group">
            <label for="protel">业务联系人电话</label>
            <input type="text" name="data[protel]" id="protel" value="<?=$re['protel']?>" class="form-control"
                               data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写业务联系人电话">
          </div>
          <div class="form-group">
            <label for="proemail">业务联系人邮箱</label>
            <input type="text" name="data[proemail]" id="proemail" value="<?=$re['proemail']?>" class="form-control"
                               data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写业务联系人邮箱">
          </div>
        </div>
        <div class="col-md-6">
        <!-- general form elements -->
          <div class="form-group">
            <label for="consigneename">收货人</label>
            <input type="text" name="data[consigneename]" id="consigneename" value="<?=$re['consigneename']?>" class="form-control"
                               data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写收货人">
          </div>
          <div class="form-group">
            <label for="consigneetel">收货人电话</label>
            <input type="text" name="data[consigneetel]" id="consigneetel" value="<?=$re['consigneetel']?>" class="form-control"
                               data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写收货人电话">
          </div>
          <div class="form-group">
            <label for="consigneeemail">收货人邮箱</label>
            <input type="text" name="data[consigneeemail]" id="consigneeemail" value="<?=$re['consigneeemail']?>" class="form-control"
                               data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写收货人邮箱">
          </div>
          <div class="form-group">
            <label for="consigneeadd">收货地址</label>
            <input type="text" name="data[consigneeadd]" id="consigneeadd" value="<?=$re['consigneeadd']?>" class="form-control"
                               data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写收货地址">
          </div>
          <div class="form-group">
            <label for="suppname">名称</label>
            <input type="text" name="data[suppname]" id="suppname"
                   value="<?= empty($re['suppname']) ? '' : $re['suppname'] ?>" class="form-control"
                   data-rule-required="false" data-rule-minlength="2" placeholder="请填写名称">
          </div>
          <div class="form-group">
            <label for="supptel">联系方式</label>
            <input type="text" name="data[supptel]" id="supptel"
                               value="<?= empty($re['supptel']) ? '' : $re['supptel'] ?>" class="form-control"
                               data-rule-required="false" data-rule-minlength="2" placeholder="请填写联系方式">
          </div>
          <div class="form-group">
            <label for="shoppname">店铺名称</label>
            <input type="text" name="data[shoppname]" id="shoppname" value="<?=$re['shoppname']?>" class="form-control" data-rule-required="true"
                               data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写店铺名称">
          </div>
          <div class="form-group">
            <label for="shopptel">店铺电话</label>
            <input type="text" name="data[shopptel]" id="shopptel" value="<?=$re['shopptel']?>" class="form-control" data-rule-required="true"
                               data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写店铺电话">
          </div>
          <div class="form-group">
            <label for="shoppadd">店铺地址</label>
            <input type="text" name="data[shoppadd]" id="shoppadd" value="<?=$re['shoppadd']?>" class="form-control"
                               data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1" placeholder="请填写店铺地址">
          </div>
          <div class="form-group">
            <label>备注</label>
            <textarea rows="3" name="data[remark]" class="form-control"><?= !empty($re) ? $re['remark'] : '' ?></textarea>
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