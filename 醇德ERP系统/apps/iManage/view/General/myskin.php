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
            <a href="">站内信息详情</a>
        </li>
    </ul>
    <div class="close-bread">
        <a href="#"><i class="fa fa-close"></i></a>
    </div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script><div class="row-fluid">
<script src="/public/assets/sysadmin/js/plugins/fileupload/bootstrap-fileupload.min.js"></script>  
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                        <h3>
                            <i class="icon-th-list"></i>
                            查看详情
                        </h3>
                       
                    </div>
            <div class="box-content nopadding">
                <form  class='form-horizontal form-bordered form-validate' action='<?=$this->url("General/sendWithinfo")?>'  id="login" name="login" method='post'>       
                           
  

                    <div class="control-group">
                        <label for="password" class="control-label">标题</label>
                        <div class="controls">
                            <input type="text" readonly="readonly"   value="<?=$re['title']?>"   class="input-xlarge"  >
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="number" class="control-label">内容</label>
                        <div class="controls">
                            <textarea  rows="3" readonly="readonly" data-rule-required="true" name="data[content]" data-rule-minlength="8" class="span8"><?=$re['content']?></textarea>
                        </div>
                    </div>
                     
                    <div class="control-group">
                        <label for="password" class="control-label">发送时间</label>
                        <div class="controls">
                            <input type="text" readonly="readonly"   value="<? echo date("Y-m-d h:i:s",$re['time'])?>"   class="input-xlarge"  data-rule-required="true" data-rule-minlength="6">
                        </div>
                    </div>

                    <div class="form-actions">
                         
                        <input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>
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
   function returnList(){
        window.location.href='<?=$this->url("General/mywebInfo")?>';
    }

   
</script>