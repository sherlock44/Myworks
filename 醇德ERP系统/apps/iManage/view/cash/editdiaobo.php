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
            <a href="">调拨审核</a>
        </li>
    </ul>
    <div class="close-bread">
        <a href="#"><i class="icon-remove"></i></a>
    </div>
</div><script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/kindeditor-min.js"></script>
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/lang/zh_CN.js"></script>
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/php/upload_json.php"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/dynatree/ui.dynatree.css">
<script src="/public/assets/sysadmin/js/jquery.cookie.js"></script>
<script src="/public/assets/sysadmin/js/plugins/dynatree/jquery.dynatree.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/js/plugins/poshytip/tip-darkgray/tip-darkgray.css">
<script src="/public/assets/sysadmin/js/plugins/poshytip/jquery.poshytip.min.js"></script>
<script>
    var editor;
    KindEditor.ready(function(K) {
            editor = K.create('textarea[name="remark"]', {
                    allowFileManager : true,
                    afterBlur: function(){this.sync();}
            });
//            editor = K.create('textarea[name="basicinfo"]', {
//                    allowFileManager : true
//            });
//            editor = K.create('textarea[name="traffic"]', {
//                    allowFileManager : true
//            });
//            editor = K.create('textarea[name="service"]', {
//                    allowFileManager : true
//            });
//            editor = K.create('textarea[name="ambient"]', {
//                    allowFileManager : true
//            });
//            editor = K.create('textarea[name="special"]', {
//                    allowFileManager : true
//            });
    });
</script> 
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-user"></i>
                </h3>
            </div>
            <div class="box-content nopadding" id="prcont">
                <form  class='form-horizontal form-bordered form-validate' action='<?=$this->url("cash/chosegood")?>'  id="login" name="login" method='post'>                                
                    
                     <div class="control-group">
                        <label for="password" class="control-label">名称</label>
                        <div class="controls">
                        <label><?=$re['title']?></label>    
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">商品名称</label>
                        <div class="controls">
                            <label><?=$re['gnm']?></label> 
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="mobile" class="control-label">商品转移源</label>
                        <div class="controls">
                            <label><?=$re['yknm'].'-'.$re['ywnm']?></label> 
                        </div>  
                    </div>
                      
                     <?if($re['step']==2){?>

                     <div class="control-group">
                        <label for="mobile" class="control-label">转出方式</label>
                        <div class="controls">
                            <label><?=$re['cktpnm']?></label> 
                        </div>  
                    </div>
                    <? } ?>
                    

                    <div class="control-group">
                        <label for="mobile" class="control-label">商品转移目的</label>
                        <div class="controls">
                          <label><?=$re['mbknm'].'-'.$re['mbwnm']?></label> 
                        </div>  
                    </div>

                     <?if($re['step']==2){?>

                     <div class="control-group">
                        <label for="mobile" class="control-label">转入方式</label>
                        <div class="controls">
                            <label><?=$re['rktpnm']?></label> 
                        </div>  
                    </div>
                    <? } ?>

                    <div class="control-group">
                        <label for="password" class="control-label">申请创建时间</label>
                        <div class="controls">
                            <label><?= date('Y-m-d h:i:s',$re['applytime'])?></label> 
                        </div>
                    </div>
                     <div class="control-group">
                        <label for="password" class="control-label">申请人</label>
                        <div class="controls">
                            <label><?=$re['name']?></label> 
                        </div>
                    </div>

                    <? if($re['step']>=2){ ?>
                    <div class="control-group">
                        <label for="password" class="control-label">入库方式</label>
                        <div class="controls">
                            <label><?=$re['rktpnm']?></label> 
                        </div>
                    </div>
                      <div class="control-group">
                        <label for="password" class="control-label">出库方式</label>
                        <div class="controls">
                            <label><?=$re['cktpnm']?></label> 
                        </div>
                    </div>
                    <? }?>

                    <? if($re['step']>=3){ ?>
                    <div class="control-group">
                        <label for="password" class="control-label">负责人</label>
                        <div class="controls">
                            <label><?=$re['fzrnm']?></label> 
                        </div>
                    </div>
                      
                    <? }?>


                    <div class="control-group">
                        <label for="password" class="control-label">数量</label>
                        <div class="controls">
                            <label><?=$re['num']?></label> 
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="number" class="control-label">备注</label>
                        <div class="controls">
                          <label><?=$re['note']?></label> 
                        </div>
                    </div>
                    <div class="form-actions">
                        <? if($re['step']==1){?>
                        <input type="button" onclick="$('#pub_edit_bootbox').removeClass('fade');$('#pub_edit_bootbox').removeClass('hide');$('#pub_edit_bootbox').attr('tabindex','1');"  class="btn btn-primary" value="<?=$sysconf['diaobostatue'][$re['step']]?>" >
                        <?}?>

                        <? if($re['step']==2){?>
                        <input type="button" onclick="$('#pub_edit_bootbox').removeClass('fade');$('#pub_edit_bootbox').removeClass('hide');$('#pub_edit_bootbox').attr('tabindex','1');"  class="btn btn-primary" value="<?=$sysconf['diaobostatue'][$re['step']]?>" >
                        <?}?>

                        <? if($re['step']==3){?>
                        <input type="button" onclick="$('#pub_edit_bootbox').removeClass('fade');$('#pub_edit_bootbox').removeClass('hide');$('#pub_edit_bootbox').attr('tabindex','1');"  class="btn btn-primary" value="<?=$sysconf['diaobostatue'][$re['step']]?>" >
                        <!--<input type="button" class="btn btn-primary" value="打印" onclick='printDIV()'>-->
                        <?}?>

                        <? if($re['step']==4){?>
                        <input type="button" onclick="$('#pub_edit_bootbox').removeClass('fade');$('#pub_edit_bootbox').removeClass('hide');$('#pub_edit_bootbox').attr('tabindex','1');"  class="btn btn-primary" value="<?=$sysconf['diaobostatue'][$re['step']]?>" >
                        <!--<input type="button" class="btn btn-primary" value="打印" onclick='printDIV()'>-->
                        <?}?>

                        <? if($re['step']==5){?>
                        <input type="button"   class="btn btn-primary" value="<?=$sysconf['diaobostatue'][$re['step']]?>" >
                        <!--<input type="button" class="btn btn-primary" value="打印" onclick='printDIV()'>-->
                        <?}?>



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
<script>
//返回列表
	function returnList(){
		window.location.href="<?=$this->url('cash/bank')?>";
	}

</script>

<?if($re['step']==1){?>
<div id="pub_edit_bootbox" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">制定调拨单</h3>
        <div class="modal-body">
			<div class="control-group">					      
                      <div class="controls">
                           <select id="cktp">
                                  <option value="">出库方式</option>
                                  <?
                                    foreach($cktp as $k=>$va){?>
                                        <option value="<?=$va['id']?>"><?=$va['title']?></option>
                                    <?}
                                ?>
                           </select>
                      </div>
                      <div class="controls">
                           <select id="rktp" >
                                  <option value="">入库方式</option>
                                   <?
                                    foreach($rktp as $k=>$va){?>
                                        <option value="<?=$va['id']?>"><?=$va['title']?></option>
                                    <?}
                                ?>
                           </select>
                      </div>
			</div>
				<div class="form-actions">
					
					<input type="button" onclick="checkcg(<?=$re['id']?>)" class="btn btn-primary" value="确认" class="btn ">
				
					<button class="btn" type="button" data-dismiss="modal" onclick="hideceng()">取消</button>
				</div>
		</div>
    </div>
</div>
</div>
<script>
	function checkcg(id){ 
		var ckid	=	$("#cktp").val();
		var rkid    =   $("#rktp").val();
		if(ckid==''||rkid==''){pub_alert_error("选择完整的出库和入库方式");return false;}
		$.ajax({
			data:{ckid:ckid,rkid:rkid,id:id},
		    url:"<?=$this->url('cash/zdcrtp')?>",
			dataType:"json",
			type:"post",
			success:function(data){
				if(data.status==1){
					pub_alert_success(data.info,1);
					location.reload();
				}else{
					pub_alert_error(data.info);
				}
			
			}
		});
	}
</script>
<?}?>
<script>
	function hideceng(){
		$('#pub_edit_bootbox').addClass('fade');$('#pub_edit_bootbox').addClass('hide');$('#pub_edit_bootbox').attr('tabindex','-1');
	}
</script>



<!--财务调拨审核 开始 -->
<?if($re['step']==2){?>

<div id="pub_edit_bootbox" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">财务调拨审核</h3>
        <div class="modal-body">
			<div class="control-group">
						
						<div class="controls">
							<select id="cgzrr" >
							<option value='0'>选择责任人</option>
							<?foreach($admin as $val){?>
							<option value="<?=$val['id']?>" ><?=$val['name']?></option>
							<?}?>
							</select>				
						</div>
			</div>
				<div class="form-actions">
					
					<input type="button" onclick="checkcg(<?=$re['id']?>)" class="btn btn-primary" value="确认" class="btn ">
				
					<button class="btn" type="button" data-dismiss="modal" onclick="hideceng()">取消</button>
				</div>
		</div>
    </div>
</div>
</div>
<script>
	function checkcg(id){
		var cgzrrid	=	$("#cgzrr").val();
		if(cgzrrid==0){pub_alert_error("选择调拨责任人");return false;}
		$.ajax({
			data:{fzrid:cgzrrid,id:id},
		    url:"<?=$this->url('cash/fzrsz')?>",
			dataType:"json",
			type:"post",
			success:function(data){
				if(data.status==1){
					//pub_alert_success(data.info,1);
					location.reload();
				}else{
					pub_alert_error(data.info);
				}
			
			}
		});
	}
</script>
<?}?>
<!--主管采购审核 结束 -->

<!--库房验单 开始 -->
<?if($re['step']==3){?>

<div id="pub_edit_bootbox" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">库房验单审核</h3>
        <div class="modal-body">
			<div class="control-group">
						
						<div class="controls">
							<select id="cgzrr" >
							<option value=''>审核选择</option>			 
							   <option value="2" >通过</option>
							   <option value="3" >配货失败</option>
							</select>				
						</div>
			</div>
				<div class="form-actions">
					
					<input type="button" onclick="checkcg(<?=$re['id']?>)" class="btn btn-primary" value="确认" class="btn ">
				
					<button class="btn" type="button" data-dismiss="modal" onclick="hideceng()">取消</button>
				</div>
		</div>
    </div>
</div>
</div>
<script>
	function checkcg(id){
		var cgzrrid	=	$("#cgzrr").val();
		if(cgzrrid==0){pub_alert_error("选择审核状态");return false;}
		$.ajax({
			data:{fzrid:cgzrrid,id:id},
		    url:"<?=$this->url('cash/kfjd')?>",
			dataType:"json",
			type:"post",
			success:function(data){
				if(data.status==1){
					//pub_alert_success(data.info,1);
					location.reload();
				}else{
					pub_alert_error(data.info);
				}
			
			}
		});
	}
</script>
<?}?>
<!--库房验单 结束 -->

<!--确认调度 开始 -->
<?if($re['step']==4){?>

<div id="pub_edit_bootbox" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">是否确认调度完成!</h3>
        <div class="modal-body">
            
                <div class="form-actions">
                    
                    <input type="button" onclick="checkcg(<?=$re['id']?>)" class="btn btn-primary" value="确认" class="btn ">
                
                    <button class="btn" type="button" data-dismiss="modal" onclick="hideceng()">取消</button>
                </div>
        </div>
    </div>
</div>
</div>
<script>
    function checkcg(id){
        $.ajax({
            data:{id:id},
            url:"<?=$this->url('cash/subdiaodu')?>",
            dataType:"json",
            type:"post",
            success:function(data){
                if(data.status==1){
                    pub_alert_success(data.info,1);
                    location.reload();
                }else{
                    pub_alert_error(data.info);
                }
            
            }
        });
    }
</script>
<?}?>
<!--库房验单 结束 -->

 