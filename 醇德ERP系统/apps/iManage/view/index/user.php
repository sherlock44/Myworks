
<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/imagesLoaded/jquery.imagesloaded.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/fileupload/bootstrap-fileupload.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<link rel="stylesheet" href="/public/adminlte/dist/css/fileupload.css">

<section class="content-header">
    <h1>
        编辑个人信息
        <small>可以编辑自己的基本信息，密码，头像，联系方式</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 醇德ERP系统</a></li>
        <li><a href="#">个人信息</a></li>
        <li class="active">编辑个人信息</li>
    </ol>
</section>
<section class="content">
    <form class="box box-default form-validate " enctype="multipart/form-data" action='<?php echo $this->url("index/saveuser");?>' id="myform" name="add_brand" method='post'>
        <div class="box-header with-border">
            <h3 class="box-title">请填写您的信息</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label>账号</label>
                        <input type="text" class="form-control" value="<?=empty($re['name'])?'':$re['name']?>" disabled/>
                    </div>
                    <div class="form-group">
                        <label>角色</label>
                        <input type="text" class="form-control" value="<?=empty($re['title'])?'':$re['title']?>" disabled/>
                    </div>
                    <div class="form-group">
                        <label>公司职务</label>
                        <input type="text" class="form-control" value="<?=empty($re['jobpost'])?'':$re['jobpost']?>" disabled/>
                    </div>
                    <div class="form-group">
                        <label>密码</label>
                        <input type="password" name="password" id="password" value="" class="form-control" data-rule-required="false" data-rule-email="false" data-rule-minlength="1">
                    </div>
                    <div class="form-group">
                        <label >确认密码</label>
                        <input type="password" name="pwd" id="pwd" value="" class="form-control" data-rule-required="false" data-rule-email="false" data-rule-minlength="1">
                    </div>
                    <div class="form-group">
                        <label for="truename">真实姓名</label>
                        <input type="text" name="data[truename]"  value="<?=!empty($re)?$re['truename']:''?>" class="form-control"  data-rule-required="true" data-rule-minlength="1">
                        <input type="hidden" name="data[id]"    value="<?php echo $re['id'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="sex">性别</label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="radio" class="minimal" name="data[sex]" value="1" <?=$re['sex']==1?'checked':'';?> /> 男
                        </label>
                        <label>
                            <input type="radio" class="minimal" name="data[sex]" value="0" <?=$re['sex']==0?'checked':'';?> /> 女 
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="email">用户邮箱</label>
                        <input type="text"  name="data[email]" value="<?php echo $re['email'] ?>" class="form-control"  data-rule-required="true" data-rule-email="true"  data-rule-minlength="1">
                    </div>
                    <div class="form-group">
                        <label for="mobile">电话号码</label>
                        <input type="text" name="data[mobile]" id="mobile" value="<?=empty($re['mobile'])?'':$re['mobile']?>" class="form-control" data-rule-required="true" data-rule-minlength="2">
                    </div>
                    <div class="form-group">
                        <label for="qq">QQ</label>
                        <input type="text" name="data[qq]" id="qq" value="<?=empty($re['qq'])?'':$re['qq']?>" class="form-control" data-rule-required="true" data-rule-minlength="2">
                    </div>
                    <div class="form-group">
                        <label for="birthday">出生日期</label>
                        <input type="text" name="data[birthday]" value="<?php if(!empty($re['birthday'])){echo date("Y-m-d",$re['birthday']);} ?>" class="form-control" data-rule-required="true" data-rule-dateISO="true" placeholder="格式:1999-02-05">
                    </div>
                    <div class="form-group">
                        <label for="imagefile">头像</label>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 150px; max-height: 150px;">
                                <img src="<?php echo !empty($re['imgpath']) ? $re['imgpath'] : '/public/assets/sysadmin/img/200_200_no_image.gif'?>" />
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                            <div style="margin-top:-10px; ">
                                <span class="btn btn-default btn-sm btn-file">
                                    <span class="fileupload-new"><i class="fa fa-photo"></i> 浏览</span>
                                    <span class="fileupload-exists"><i class="fa fa-edit"></i> 重选</span>
                                    <input type="file" name="imagefile" id="imagefile"  />
                                </span>
                                <span class="btn btn-danger btn-sm fileupload-exists" data-dismiss="fileupload"><i class="fa fa-remove"></i> 移除</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <input type="submit" class="btn btn-primary" value="保存" >
        </div>
    </form>
</section>
