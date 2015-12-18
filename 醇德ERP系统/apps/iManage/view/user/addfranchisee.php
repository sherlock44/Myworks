<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script> 
<section class="content-header">
  <h1>
    我的客户管理
    <small>添加我的客户</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
    <li><a href="#">客户管理</a></li>
    <li class="active">我的客户管理</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <form  class='box box-primary form-validate' action='<?=$this->url("user/insertfranchisee")?>'  id="login" name="login" method='post'>
    <div class="box-header with-border">
      <h3 class="box-title">请填写客户信息</h3>
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
            <label for="name">账号</label>
            <input type="text" name="data[username]" id="data[username]" value="" class="form-control valid"
            data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">   
          </div>
          <div class="form-group">
            <label for="addr">公司名称</label>
            <input type="text" name="data[commname]" id="data[commname]" value="" class="form-control valid"
            data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div> 
          <div class="form-group">
            <label for="mobile">公司电话</label>
            <input type="text" name="data[commtel]" id="data[commtel]" value="" class="form-control valid"
            data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div> 
          <div class="form-group">
            <label for="dutyemail">公司地址</label>
            <input type="text" name="data[comaddress]" id="data[comaddress]" value="" class="form-control valid"
            data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label for="titlesss">客户类型</label>
            <select name="data[supplytypeid]" class="form-control">
              <? foreach ($supplytype as $k => $val) { ?>
              <option value="<?= $val['id'] ?>"><?= $val['title'] ?></option>
              <? } ?>
            </select>
          </div>
          <div class="form-group">
            <label >负责人姓名</label>
            <input type="text" name="data[truename]" id="data[truename]" value="" class="form-control valid"
            data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label >负责人电话</label>
            <input type="text" name="data[mobile]" id="data[mobile]" value="" class="form-control valid"
            data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label >负责人邮箱</label>
            <input type="text" name="data[email]" id="email" value="" class="form-control valid"
            data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label >收货人姓名</label>
            <input type="text" name="data[consigneename]" id="data[consigneename]" value="" class="form-control valid"
            data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label >收货人电话</label>
            <input type="text" name="data[consigneetel]" id="data[consigneetel]" value="" class="form-control valid"
            data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label for="type">所属区域</label>
            <select  class="form-control" name="data[proviceid]" class="input-small" onchange="javascript:$('#cityid').html('');$('#areaid').html('');bindSelect('/index.php/iManage/area/getRegion?parentid='+this.value,'cityid');">
              <?foreach ($province as $key=>$val){?>
              <option value="<?=$val['id']?>"><?=$val['name']?></option>
              <?}?>
            </select>
            <br />
            <select  class="form-control" id="cityid" name="data[cityid]"  onchange="javascript:$('#areaid').html('');bindSelect('/index.php/iManage/area/getRegion?parentid='+this.value,'areaid');">
              <option value="0">市</option>
            </select>
            <br />
            <select  class="form-control" name="data[areaid]"  id="areaid">
              <option value="0">区/县</option>
            </select>
          </div>
          <div class="form-group">
            <label >备注</label>
            <textarea rows="3" name="data[remark]" class="form-control"><?= !empty($re) ? $re['remark'] : '' ?></textarea>
          </div>
        </div>
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="form-group">
            <label for="password">密码</label>
            <input type="password" name="data[password]" id="data[password]" value="" class="form-control valid"
            data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label for="addr">确认密码</label>
            <input type="password" name="pwd" id="pwd" value="" class="form-control valid" data-rule-required="true"
            data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label >加盟商名字</label>
            <input type="text" name="data[suppname]" id="data[suppname]" value="<?= empty($re['phone']) ? '' : $re['phone'] ?>" class="form-control valid"
            data-rule-required="true" data-rule-minlength="2">
          </div>
          <div class="form-group">
            <label >加盟商联系方式</label>
            <input type="text" name="data[supptel]" id="data[supptel]" value="<?= empty($re['phone']) ? '' : $re['phone'] ?>" class="form-control valid" data-rule-required="true" data-rule-minlength="2">
          </div>
          <div class="form-group">
            <label >状态</label>
            <select name='data[status]' class="form-control">
              <option value='1'>正常</option>
              <option value='0'>冻结</option>
            </select>
          </div>
          <div class="form-group">
            <label >业务联系人姓名</label>
            <input type="text" name="data[proname]" id="data[proname]" value="" class="form-control valid"
            data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label >业务联系人电话</label>
            <input type="text" name="data[protel]" id="data[protel]" value="" class="form-control valid"
            data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label >业务联系人邮箱</label>
            <input type="text" name="data[proemail]" id="data[proemail]" value="" class="form-control valid"
            data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label >收货人邮箱</label>
            <input type="text" name="data[consigneeemail]" id="data[consigneeemail]" value="" class="form-control valid"
            data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label >收货地址</label>
            <input type="text" name="data[consigneeadd]" id="data[consignee add]" value="" class="form-control valid"
            data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label for="type">地址</label>
            <textarea  rows="3" name="data[address]" class="form-control"><?=!empty($re) ? $re['address']: ''?></textarea>
          </div>
        </div>
      </div>
    </div>
    <div class="box-header with-border">
      <h3 class="box-title">打印小票设置</h3>
      <div class="box-tools pull-right">
        <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="form-group">
            <label for="titlesss">店铺名称</label>
            <input type="text" name="data[shoppname]" id="data[shoppname]" value="" class="form-control valid" data-rule-required="true"
            data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label for="titlesss">店铺电话</label>
            <input type="text" name="data[shopptel]" id="data[shopptel]" value="" class="form-control valid" data-rule-required="true"
            data-rule-mobile="false" data-rule-minlength="1">
          </div>
        </div>
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="form-group">
            <label for="password">店铺地址</label>
            <input type="text" name="data[shoppadd]" id="data[shoppadd]" value="" class="form-control valid"
            data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
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
  window.location.href="<?=$this->url('user/franchisee')?>";
}
</script>
