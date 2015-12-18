    <div id="main">
            <div class="container-fluid nopadding">
<div class="breadcrumbs">
    <ul>
        <li>
            <a href="<?=$_SESSION['indexmain']?>">后台管理</a>
            <i class="icon-angle-right"></i>
        </li>
        <li>
            <a href="">调拨管理</a>
            <i class="icon-angle-right"></i>
        </li>
        <li>
            <a href="">提交申请</a>
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
                <form  class='form-horizontal form-bordered form-validate' action='<?=$this->url("cash/chosegood")?>'  id="login" name="login" method='post'>                                
                    
                     <div class="control-group">
                        <label for="password" class="control-label">名称</label>
                        <div class="controls">
                            <input type="text"   name="data[title]"   class="input-xlarge"   data-rule-required="true" >
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">选择调度商品</label>
                        <div class="controls">
                            <select data-rule-required="true" name="data[goodsid]" onchange="changehouse(this.value)">
                                    <option value="">请选择商品</option>
                                <?
                                    foreach($re as $k=>$v){?>
                                        <option value="<?=$v['id']?>"><?=$v['title']?></option>
                                    <?}
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="mobile" class="control-label">商品转移源</label>
                        <div class="controls">
                          <select data-rule-required="true" name="data[ykw]" id="ky">
                                    <option value="">选择位置</option>
                                </select>   
                        </div>  
                    </div>     
                    <div class="control-group">
                        <label for="mobile" class="control-label">商品转移目的</label>
                        <div class="controls">
                          <select data-rule-required="true" name="data[mbkw]" id="mby">
                                    <option value="">选择位置</option>
                                </select>   
                        </div>  
                    </div>
                    <div class="control-group">
                        <label for="password" class="control-label">数量</label>
                        <div class="controls">
                            <input type="text"   name="data[num]"   class="input-xlarge" data-rule-number="true"  data-rule-required="true" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="number" class="control-label">备注</label>
                        <div class="controls">
                            <textarea  rows="3"  name="data[note]"  class="span8"></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="提交申请" >
                    </div>       
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script>
    function changehouse(goodsid){
        
        if(goodsid==''){
            var html    =   "<option value=''>选择位置</option>";
            $("#ky").html(html);
            $("#mby").html(html); 
        }else{
            $.ajax({
                data:{goodsid:goodsid},
                url:"<?=$this->url('cash/getpoi')?>",
                type:"post",
                dataType:"json",
                success:function(data){
                    $("#ky").html(data.html);
                    $("#mby").html(data.html);             
                }         
            });
        }
    }
</script>
