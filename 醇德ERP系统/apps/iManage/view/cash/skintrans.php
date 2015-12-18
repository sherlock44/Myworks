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
            <a href=""><?=$sysconf['diaobostatue'][$re['step']]?></a>
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
    });
</script> 

<?if($re['step']>=2){?>
<div class="row-fluid">
            <div class="span12">
                <div class="box box-color box-bordered">
                    <div class="box-title">
                        <h3>
                            <i class="icon-th-list"></i>
                            出库商品列表
                        </h3>
                        
                    </div>
                    <div class="box-content nopadding">
                    <div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
                    
                        <table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                            <thead>
                                <tr>                           
                            <th width="10%">商品名称</th>
                            <th width="10%">商品编号</th>                                                                                                                                                                             
                            <th width="5%">数量</th>   
                            <th width="5%">库房</th>
                            <th width="5%">库位</th>                                              
                        </tr>
                            </thead>
                            <?
                                foreach($goods as $key=>$value){
                            ?>
                            <tr>
                            
                            <td><?=$value['title']?>&nbsp;<img width=50 height=50   src="<?=$value["imgpath"]?>"></td>
                            <td><?=$value['barcode']?></td>
                        
                        
                            
                            <td>
                        <?=$value['num']?>
                            </td>
                            
                            <td><?=$value['phtitle']?></td>
                            <td><?=$value['phstitle']?></td>    
                                
                            </tr>
                            <?
                                }
                            ?>
                        </table>
                        <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
                        
                                
                        
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    
    

    <?}?>
<div class="row-fluid">
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

                    <div class="control-group">
                        <label for="password" class="control-label">主管</label>
                        <div class="controls">
                            <label><?=$re['zgnm']?></label> 
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="number" class="control-label">备注</label>
                        <div class="controls">
                          <label><?=$re['note']?></label> 
                        </div>
                    </div>
                    <?if($re['step']>=2){?>
                       <div class="control-group">
                        <label for="number" class="control-label">入库类型</label>
                        <div class="controls">
                          <label><?=$re['rktpnm']?></label> 
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="number" class="control-label">入库说明</label>
                        <div class="controls">
                          <label><?=$re['inremark']?></label> 
                        </div>
                    </div>


                    <?}?>

                    <?if($re['step']>=8){?>
                       <div class="control-group">
                        <label for="number" class="control-label">物流单号</label>
                        <div class="controls">
                          <label><?=$re['wlno']?></label> 
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="number" class="control-label">配货人</label>
                        <div class="controls">
                          <label><?=$re['phunm']?></label> 
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="number" class="control-label">配货人电话</label>
                        <div class="controls">
                          <label><?=$re['phphone']?></label> 
                        </div>
                    </div>
                    <?}?>
                    <div class="control-group">
                        <label for="number" class="control-label">当前状态</label>
                        <div class="controls">          
                            <?=$sysconf['diaobostatue'][$re['step']]?>                         
                        </div>              
                    </div>
                    <div class="form-actions">
                        <!-- 制定调拨单-->
                        <? if($re['step']==1){?>
                        <input type="button" onclick="javascript:window.location.href='<?=$this->url("cash/tranchgood",array("id"=>$re["id"]))?>'"  class="btn btn-primary" value="<?=$sysconf['diaobostatue'][$re['step']]?>" >
                        <?}?>
                        <!--财务审核 -->
                        <? if($re['step']==2){?>
                        <input type="button" onclick="$('#pub_edit_bootbox').removeClass('fade');$('#pub_edit_bootbox').removeClass('hide');$('#pub_edit_bootbox').attr('tabindex','1');"  class="btn btn-primary" value="<?=$sysconf['diaobostatue'][$re['step']]?>" >
                        <?}?>
                        <!-- 调拨至库房-->
                        <? if($re['step']==3){?>
                         <input type="button" onclick="$('#pub_edit_bootbox').removeClass('fade');$('#pub_edit_bootbox').removeClass('hide');$('#pub_edit_bootbox').attr('tabindex','1');"  class="btn btn-primary" value="<?=$sysconf['diaobostatue'][$re['step']]?>" >
                        
                        <?}?>
                        <!--库房确认配货 -->
                        <? if($re['step']==4){?>
                        <input type="button" onclick="$('#pub_edit_bootbox').removeClass('fade');$('#pub_edit_bootbox').removeClass('hide');$('#pub_edit_bootbox').attr('tabindex','1');"  class="btn btn-primary" value="<?=$sysconf['diaobostatue'][$re['step']]?>" >
                        <?}?>
                        <!--库房核验-->
                        <? if($re['step']==5){?>
                        <input type="button" onclick="$('#pub_edit_bootbox').removeClass('fade');$('#pub_edit_bootbox').removeClass('hide');$('#pub_edit_bootbox').attr('tabindex','1');"  class="btn btn-primary" value="<?=$sysconf['diaobostatue'][$re['step']]?>" >          
                        <?}?>
                        <!--库房核验通过 物流录入-->
                        <? if($re['step']==6){?>
                        <input type="button" onclick="javascript:window.location.href='<?=$this->url("cash/inserwl",array("id"=>$re["id"]))?>'"  class="btn btn-primary" value="<?=$sysconf['diaobostatue'][$re['step']]?>" >          
                        <?}?>
                        <!--库房核验失败 -->
                        <? if($re['step']==7){?>
                        <input type="button" onclick="javascript:window.location.href='<?=$this->url("cash/resubkwinfo",array("id"=>$re["id"]))?>'"  class="btn btn-primary" value="配货错误 重新配置" >          
                        <?}?>
                        <!-- 入库确认-->
                        <!--库房核验-->
                        <? if($re['step']==8){?>
                        <input type="button" onclick="$('#pub_edit_bootbox').removeClass('fade');$('#pub_edit_bootbox').removeClass('hide');$('#pub_edit_bootbox').attr('tabindex','1');"  class="btn btn-primary" value="<?=$sysconf['diaobostatue'][$re['step']]?>" >          
                        <?}?>
                        <!--确认收货 -->
                        <? if($re['step']==9){?>
                        <input type="button" onclick="$('#pub_edit_bootbox').removeClass('fade');$('#pub_edit_bootbox').removeClass('hide');$('#pub_edit_bootbox').attr('tabindex','1');"  class="btn btn-primary" value="<?=$sysconf['diaobostatue'][$re['step']]?>" >          
                        <?}?>
                        <!--货物损坏 -->
                        <? if($re['step']==10){?>
                        <input type="button" onclick="javascript:window.location.href='<?=$this->url("cash/goodDestory",array("id"=>$re["id"]))?>'"  class="btn btn-primary" value="损坏登记" >         
                        <?}?>
                        <!--货物丢失 -->
                        <? if($re['step']==11){?>
                        <input type="button" onclick="javascript:window.location.href='<?=$this->url("cash/goodLoss",array("id"=>$re["id"]))?>'"  class="btn btn-primary" value="丢失登记" >          
                        <?}?>
                        <!-- 入库结束-->
                        <? if($re['step']==12){?>
                        <input type="button"  class="btn btn-primary" value="<?=$sysconf['diaobostatue'][$re['step']]?>" >          
                        <?}?>



                        <?if($re['step']>=4){?>
                          <input type="button" class="btn btn-primary" value="打印" onclick='printDIV()'>
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



<!--财务审核 开始 -->
<?if($re['step']==2){?>

<div id="pub_edit_bootbox" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">财务审核确认通过,锁定库房</h3>
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
		    url:"<?=$this->url('cash/subruku')?>",
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


<!--财务审核 结束 -->

<!--调拨单至库房 开始 -->
<?if($re['step']==3){?>

<div id="pub_edit_bootbox" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">确认调拨单至库房</h3>
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
<!--调拨单至库房 结束 -->

<!--库房配货 开始 -->
<?if($re['step']==4){?>

<div id="pub_edit_bootbox" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">确认配货!</h3>
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
            url:"<?=$this->url('cash/kfpeihuo')?>",
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
<!--库房配货 结束 -->



<!--库房核验 开始 -->
<?if($re['step']==5){?>

<div id="pub_edit_bootbox" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">库房核验</h3>
        <div class="modal-body">
                <div class="form-actions">
                      <div class="controls">
                           <select id="step" >
                                  <option value="">请选择</option>
                                  <option value="6">审核通过</option>
                                  <option value="7">配货错误</option>
                           </select>
                      </div>
                    
                    <input type="button" onclick="checkcg(<?=$re['id']?>)" class="btn btn-primary" value="确认" class="btn ">           
                    <button class="btn" type="button" data-dismiss="modal" onclick="hideceng()">取消</button>
                </div>
        </div>
    </div>
</div>
</div>
<script>
    function checkcg(id){
         var step    =   $("#step").val();
        if(step==''){pub_alert_error("选择是否通过");return false;}
        $.ajax({
            data:{id:id,step:step},
            url:"<?=$this->url('cash/checkpeih')?>",
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


<!--库房核验 结束 -->



<!--库房配货审核 开始 -->
<?if($re['step']==8){?>

<div id="pub_edit_bootbox" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">调入库是否确认收货!</h3>
        <div class="modal-body">

                    <div class="controls">
                           <select id="step" onChange="chostep(this.value)">
                                  <option value="">请选择</option>
                                  <option value="9">确认收货</option>
                                  <option value="1">货物漏发</option>
                                  <option value="10">货物损坏</option>
                                  <option value="11">货物丢失</option>
                           </select>
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
        var step    =   $("#step").val();
        if(step==''){pub_alert_error("选择是否确认收货");return false;}
        $.ajax({
            data:{id:id,step:step},
            url:"<?=$this->url('cash/checkShouh')?>",
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
<!--库房配货审核 结束 -->

<!--确认入库 开始 -->
<?if($re['step']==9){?>

<div id="pub_edit_bootbox" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">是否确认调度完成</h3>
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
            url:"<?=$this->url('cash/endDiaobo')?>",
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


<!--财务审核 结束 -->




<script type="text/javascript">
    function printDIV(){
        window.print();
        return false;
    }
</script>

 