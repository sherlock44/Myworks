    <div id="main">
            <div class="container-fluid nopadding">

<div class="breadcrumbs">
    <ul>
        <li>
            <a href="<?=$_SESSION['indexmain']?>">后台管理</a>
            <i class="icon-angle-right"></i>
        </li>
        <li>
            <a href="">通用管理</a>
            <i class="icon-angle-right"></i>
        </li>
        <li>
            <a href="">个人信息</a>
        </li>
    </ul>
    <div class="close-bread">
        <a href="#"><i class="fa fa-close"></i></a>
    </div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/fileupload/bootstrap-fileupload.min.js"></script>  
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-user"></i>
                    编辑个人信息
                </h3>
            </div>
            <div class="box-content nopadding">
                <form  class='form-horizontal form-bordered form-validate' action='<?=$this->url("General/saveuser")?>'  id="login" name="login" method='post'>       
                           
					 <div class="control-group">
						<label class="control-label">账号</label>
						<div class="controls">
							<?=empty($re['name'])?0:$re['name']?>
						</div>
					</div>
					 <div class="control-group">
						<label class="control-label">角色</label>
						<div class="controls">
							<?=empty($re['title'])?'':$re['title']?>
						</div>
					</div>
					 <div class="control-group">
						<label class="control-label">公司职务</label>
						<div class="controls">
							<?=empty($re['jobpost'])?'':$re['jobpost']?>
						</div>
					</div>
					<div class="control-group">
						<label  class="control-label">密码</label>
						<div class="controls">
							<input type="password" name="password" id="password" value="" class="input-xlarge" data-rule-required="false" data-rule-email="false" data-rule-minlength="1">
						</div>
					</div>
					<div class="control-group">
						<label  class="control-label">确认密码</label>
						<div class="controls">
							<input type="password" name="pwd" id="pwd" value="" class="input-xlarge" data-rule-required="false" data-rule-email="false" data-rule-minlength="1">
						</div>
					</div>
					
                    <div class="control-group">
                        <label for="password" class="control-label">真实姓名</label>
                        <div class="controls">
                            <input type="text"   name="data[truename]"  value="<?=!empty($re)?$re['truename']:''?>" class="input-xlarge"  data-rule-required="true" data-rule-minlength="1">
                            <input type="hidden" name="data[id]"    value="<?php echo $re['id'] ?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="password" class="control-label">性别</label>
                        <div class="controls">         
                            <input type="radio"  name="data[sex]" value="1" class="input-xlarge"  <?php if($re['sex']==1) { ?> checked="" <?php } ?> /> 男
                            <input type="radio"  name="data[sex]" value="0" class="input-xlarge"  <?php if($re['sex']==0) { ?> checked="" <?php } ?>  /> 女 
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="password" class="control-label">用户邮箱</label>
                        <div class="controls">
                            <input type="text"  name="data[email]" value="<?php echo $re['email'] ?>" class="input-xlarge"  data-rule-required="true" data-rule-email="true"  data-rule-minlength="1">
                        </div>
                    </div>
					<div class="control-group">
						<label class="control-label">电话号码</label>
						<div class="controls">
							<input type="text" name="data[mobile]" id="mobile" value="<?=empty($re['mobile'])?'':$re['mobile']?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="2">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">QQ</label>
						<div class="controls">
							<input type="text" name="data[qq]" id="mobile" value="<?=empty($re['qq'])?'':$re['qq']?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="2">
						</div>
					</div>
                     <div class="control-group">
                        <label for="password" class="control-label">出生日期</label>
                        <div class="controls">
                            <input type="text" name="data[birthday]" value="<?php if(!empty($re['birthday'])){echo date("Y-m-d",$re['birthday']);} ?>" class="input-xlarge" data-rule-required="true" data-rule-dateISO="true" placeholder="格式:1999-02-05">
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="textfield" class="control-label">头像</label>
                        <div class="controls">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 150px; max-height: 150px;"><img src="<? echo $re['imgpath'] ?>" /></div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-file"><span class="fileupload-new">浏览</span><span class="fileupload-exists">重选</span>
                                    <input type="file" name='imagefile' />
                                    </span>
                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">移除</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="保存" >
                    </div>
                    
                  
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script>
//返回列表
    /*function control(){
        window.location.href='<?=$this->url("system/control")?>';
    }

    $('#login').submit(function(){
    var data = $("#login").serialize();
    $.ajax({
        type:'POST',
        url:'<?=$this->url("system/check_modify")?>',
        data:data,
        dataType:'json',
        success:function(r){
            if(r.state == 1){
                alert('修改成功');
                window.location.href="<?=$this->url('system/control')?>";
            }else{
                $('#login').before('<div class="alert alert-error"><button data-dismiss="alert" class="close" type="button">×</button><strong>'+r.info+'</strong></div>');
            }
        }
    });
    return false;
});*/
</script>