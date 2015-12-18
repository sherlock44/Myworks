    <div id="main">
            <div class="container-fluid nopadding" >

</div>
 
<div class="breadcrumbs">
    <ul>
        <li>
            <a href="<?=$_SESSION['indexmain']?>">后台管理</a>
            <i class="icon-angle-right"></i>
        </li>
        <li>
            <a href="">系统管理</a>
            <i class="icon-angle-right"></i>
        </li>
        <li>
            <a href="">系统备份</a>
        </li>
    </ul>
    <div class="close-bread">
        <a href="#"><i class="fa fa-close"></i></a>
    </div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/fileupload/bootstrap-fileupload.min.js"></script>  <div class="row-fluid nopadding">
    <div class="span12 nopadding">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <h3>
                    <i class="icon-th-list"></i>
                    系统备份
                </h3>
                </h3>
            </div>
            <div class="box-content nopadding" style="padding:0;">
                <form  class='form-horizontal form-bordered form-validate' action='<?=$this->url("log/sysBack")?>'  id="login" name="login" method='post'>       
                           
                    <div class="control-group">
                        <label for="password" class="control-label">文件名称</label>
                        <div class="controls">
                            <input type="text"   name="filename"   class="input-xlarge" value="<?=date('Ymdhis')."data"?>"  data-rule-required="true" data-rule-minlength="4">
                            <span style="color:red;">文件保存在data目录下</span>
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="开始备份" >
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