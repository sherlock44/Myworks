<link rel="stylesheet" href="/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="/public/adminlte/plugins/daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="/public/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap time picker -->
<script src="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<section class="content-header">
  <h1>
    意向客户
    <small>编辑意向客户</small>
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
      <h3 class="box-title">编辑意向客户</h3>
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
              <option value="<?=$k?>" <?=($k==$re['source'])?'selected':''?>><?=$v?></option>
              <?}
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="name">公司名称</label>
            <input type="text" name="data[name]" id="name"  value="<?=$re['name']?>" class="form-control valid" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label for="addr">负责人姓名</label>
            <input type="text" name="data[dutyname]" id="name" value="<?=$re['dutyname']?>"  class="form-control valid" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div> 
          <div class="form-group">
            <label for="mobile">负责人电话</label>
            <input type="text" name="data[mobile]" id="data[mobile]" value="<?=$re['mobile']?>"   class="form-control valid" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div> 
          <div class="form-group">
            <label for="dutyemail">负责人邮箱</label>
            <input type="text" name="data[dutyemail]" id="data[dutyemail]"  value="<?=$re['dutyemail']?>" class="form-control valid" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
          </div>
          <div class="form-group">
            <label >客户主营业务(产品渠道等)</label>
            <textarea class="form-control" name="data[intro]" rows="3"><?=$re['intro']?></textarea>
          </div>
        </div>
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="form-group">
            <label for="password">所属区域</label>
            <select name="data[proviceid]"  class="form-control" onchange="javascript:$('#cityid').html('');$('#areaid').html('');bindSelect('/index.php/iManage/area/getRegion?parentid='+this.value,'cityid');">
              <?foreach ($province as $key=>$val){?>
              <option value="<?=$val['id']?>" <?=($val['id']==$area['provice_id'])?'selected':''?> ><?=$val['name']?>省</option>
              <?}?>
            </select>
            <br />
            <select id="cityid" name="data[cityid]"  class="form-control" onchange="javascript:$('#areaid').html('');bindSelect('/index.php/iManage/area/getRegion?parentid='+this.value,'areaid');">
              <?foreach ($citys as $key=>$city){?>
              <option  value="<?=$city['id']?>" <?=($city['id']==$area['city_id'])?'selected':''?>><?=$city['name']?>市</option>
              <?}?>
            </select>
            <br />
            <select name="data[areaid]"  class="form-control" id="areaid">
              <?foreach ($areas as $key=>$area_add){?>
              <option value="<?=$area_add['id']?>" <?=($area_add['id']==$area['area_id'])?'selected':''?>><?=$area_add['name']?>区/县</option>
              <?}?>
            </select>
          </div>
          <div class="form-group">
            <label for="addr">公司地址</label>
            <input type="text" name="data[addr]" id="data[addr]" value="<?=$re['addr']?>"  class="form-control valid" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1"> 
          </div>
          <div class="form-group">
            <label for="type">客户类型</label>
            <select name="data[type]" class="form-control">
              <?foreach($usertype as $val){?>
              <option value="<?=$val['id']?>" <?=($val['id']==$re['type'])?'selected':''?>><?=$val['title']?></option>
              <?}?>
            </select>
          </div>
          <div class="form-group">
            <label for="type">意向类型</label>
            <select name="data[intention_type]" class="form-control">
              <?
              foreach($sysconf['intention_type'] as $k=>$v){?>
              <option value="<?=$k?>" <?=($k==$re['intention_type'])?'selected':''?>><?=$v?></option>
              <?}
              ?>
            </select>
          </div>
          <div class="form-group">
            <label >合作意向</label>
            <textarea class="form-control" name="data[intent]" rows="3"><?=$re['intent']?></textarea>
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
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">回访纪录</h3>
          <?if($re['status']==0){?>
          <div class="box-tools pull-right">
            <a rel="tooltip" data-original-title="添加" href="javascript:void(0)" data-toggle="modal" data-target="#pub_edit_bootbox" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> 添加</a>
          </div>
          <?}?>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-init">
              <thead>
                <tr>
                  <th>回访日期</th>
                  <th>回访内容</th>
                  <th>下次回访日期</th>
                  <th>下次回访事项</th>
                </tr>
              </thead>
              <tbody>
                <?foreach($log as $val){?>
                <tr>
                  <td><?=date("Y-m-d H:i",$val['visittime'])?></td>
                  <td><?=$val['content']?></td>
                  <td><?if($val['status']==1){?>回访结束<?}else{?><?=date("Y-m-d H:i",$val['nextvisittime'])?><?}?></td>
                  <td><?=$val['nextcontent']?></td>
                </tr>
                <?}?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<!-- bootstrap time picker -->
<script src="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<div id="pub_edit_bootbox" class="modal fade">
  <form class="modal-dialog form-validate" style="margin-top:50px;" id="modalform" action="<?=$this->url('user/customerlog')?>" method="post">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">回访纪录</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="productontime">回访日期</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input id="productontime" name="productontime" class="form-control" placeholder="请选择回访日期"  type="text" data-rule-required="true"/>
          </div><!-- /.input group -->
        </div>
        <div class="form-group">
          <label for="thiscontent">回访内容</label>
          <textarea id="thiscontent" name="thiscontent" class="form-control" data-rule-required="true" placeholder="请输入回访内容"></textarea>
        </div>
        <div class="form-group">
          <label for="checkstate">回访结果</label>
          <select class="form-control" name="checkstate" id="checkstate">
            <option value="0">待下次回访</option>
            <option value="1">回访结束,不用再回访</option>
          </select>
        </div>
        <div class="form-group tagnext">
          <label for="nexttime">下次回访日期</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input name="nexttime" id="nexttime" class="form-control" placeholder="请选择下次回访日期" type="text" />
          </div>
        </div>
        <div class="form-group tagnext">
          <label for="nextcontent">下次回访事项</label>
          <textarea class="form-control" name="nextcontent" id="nextcontent" placeholder="请输入下次回访事项"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="id" name="id" value="<?=$re['id']?>" />
        <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> 提交</button>
        <button class="btn btn-default" type="button" onclick="returnList()"><i class="fa fa-reply"></i> 返回</button>
      </div>
    </div>
  </form>
</div>
<script>
  function returnList(){
    window.location.href="<?=$this->url('user/customer')?>";
  }
  $(function () {
    $('#productontime').daterangepicker({
      singleDatePicker: true,
      language: 'zh-CN',
      format: 'YYYY-MM-DD'
    });
    $('#nexttime').daterangepicker({
      singleDatePicker: true,
      language: 'zh-CN',
      format: 'YYYY-MM-DD'
    });
    $('#checkstate').change(function(){
      if($(this).val() == 0) {
        $(".tagnext").show();
      } else{
        $(".tagnext").hide();
      }
    });
  });
</script>