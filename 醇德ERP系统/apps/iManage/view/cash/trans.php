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
            <a href="">发站内信</a>
        </li>
    </ul>
    <div class="close-bread">
        <a href="#"><i class="icon-remove"></i></a>
    </div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script><div class="row-fluid">
<script src="/public/assets/sysadmin/js/plugins/fileupload/bootstrap-fileupload.min.js"></script>  
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-user"></i>
                </h3>
            </div>
            <div class="box-content nopadding">
                <form  class='form-horizontal form-bordered form-validate' action='<?=$this->url("General/sendWithinfo")?>'  id="login" name="login" method='post'>       
                           
  
                    <div class="control-group">
                        <label class="control-label">接受者</label>
                        <div class="controls">
                            <select name="data[reuserid]">
                                <?
                                    foreach($re as $k=>$v){?>
                                        <option value="<?=$v['id']?>"><?=$v['name']?></option>
                                    <?}
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="password" class="control-label">标题</label>
                        <div class="controls">
                            <input type="text"   name="data[title]"   class="input-xlarge"  data-rule-required="true" data-rule-minlength="6">
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="number" class="control-label">内容</label>
                        <div class="controls">
                            <textarea  rows="3" data-rule-required="true" name="data[content]" data-rule-minlength="8" class="span8"></textarea>
                        </div>
                </div>
                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="发送" >
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