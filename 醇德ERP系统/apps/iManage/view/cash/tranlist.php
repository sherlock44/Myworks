<div id="main">
    <div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">调拨商品管理</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div>
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/kindeditor-min.js"></script>
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/lang/zh_CN.js"></script>
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/php/upload_json.php"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/dynatree/ui.dynatree.css">
<script src="/public/assets/sysadmin/js/jquery.cookie.js"></script>
<script src="/public/assets/sysadmin/js/plugins/dynatree/jquery.dynatree.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/js/plugins/poshytip/tip-darkgray/tip-darkgray.css">
<script src="/public/assets/sysadmin/js/plugins/poshytip/jquery.poshytip.min.js"></script>
        <div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					调拨商品列表
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					<div id="DataTables_Table_0_length" class="dataTables_length" style="height:36px;">				
					<div class="row-fluid"  style="width:1000px;height:5px;">
                                             
				</div>
                   </div>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        						<tr>
							
							<th width="10%">商品名称</th>
							<th width="10%">商品编号<br/>拼音码</th>
							
							
							
							<th width="10%">价格</th>
											
							<th width="10%">库存</th>							
							
							<th width="15%">数量</th>
							<th width="15%">操作</th>
							
					
						
						</tr>
        					</thead>
                            <?
                                foreach($re as $key=>$value){
                            ?>
                            <tr>
							
							<td><?=$value['title']?>&nbsp;<img width=50 height=50   src="<?=$value["imgpath"]?>"></td>
							<td><?=$value['barcode']?><br/><?=$value['pingyincode']?></td>
							<td><?=$value['costprice']?></td>	
							
							<td><?=$value['number']?></td>
							<td>
							<input type="text" id="goodsnum_<?=$value['cartid']?>" name="goodsnum_<?=$value['cartid']?>" onchange="changenum(<?=$value['cartid']?>)"  value="<?=$value['num']?>" class="span8" data-rule-required="true" data-rule-number="true" data-rule-minlength="1" placeholder="只能填数字">
							</td>
							<td>
								
							
							
								<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("cash/deltrangood")?>?id=<?=$value["cartid"]?>');" class="btn btn-small btn-danger" title="删除"><i class="icon-remove"></i></a>
								
							</td>							
							</tr>
                            <?
                                }
                            ?>
        				</table>
						<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
						
						   <!--     <button class="btn btn-primary"  onclick="$('#pub_edit_bootbox').removeClass('fade');$('#pub_edit_bootbox').removeClass('hide');$('#pub_edit_bootbox').attr('tabindex','1');">选择调入库房&nbsp;&nbsp;<i class="icon-shopping-cart"></i></button>  -->
						        <button class="btn btn-primary"  onclick="javascript:window.location.href='<?=$this->url("cash/subkwinfo",array('id'=>$transid))?>'">填写其他信息&nbsp;&nbsp;<i class="icon-shopping-cart"></i></button>  
						</div>
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
	</div>
</div>

<div id="pub_edit_bootbox" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">库位选择</h3>
        <div class="modal-body">
			<div class="control-group">
						
						<div class="controls">
							<select id="cgzrr" >
							<option value=''>选择库位</option>
							<?foreach($kwdt as $val){?>
							<option value="<?=$val['id']?>" ><?=$val['ptitle'].'-'.$val['title']?></option>
							<?}?>
							</select>				
						</div>
			</div>
				<div class="form-actions">
					
					<input type="button" onclick="checkcg(<?=$transid?>)" class="btn btn-primary" value="确认" class="btn ">
				
					<button class="btn" type="button" data-dismiss="modal" onclick="hideceng()">取消</button>
				</div>
		</div>
    </div>
</div>
</div>
<script>
	function checkcg(id){

		//window.location.href ='<?=$this->url("cash/bank")?>';
		var kwid	=	$("#cgzrr").val();
		if(kwid==0){pub_alert_error("请选择库位信息");return false;}
		$.ajax({
			data:{kwid:kwid,id:id},
		    url:"<?=$this->url('cash/subtrankw')?>",
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


<script>
	//修改采购数量
	function changenum(id){
		var num	=	$("#goodsnum_"+id).val();
		if(isNaN(num)){return false;}
		$.ajax({
			url:"<?=$this->url('cash/updatetranum')?>",
			data:"id="+id+"&num="+num,
			type:"post",
			dataType:"json",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
					if(r.data == 'back'){
					setTimeout('location.reload()',600);
					}
				  }else{
					pub_alert_error(r.info);
				  }
			}	
		});
	}
	//提交
	function tjcart(){
		var remark	=	$("#remarkcart").val();
		$.ajax({
			url:"<?=$this->url('cash/tjcart')?>",
			data:{remark:remark},
			type:"post",
			dataType:"json",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
					setTimeout('window.location.href="<?=$this->url('cash/orderconfirm')?>"',600);
					/* if(r.data == 'back'){
					setTimeout('location.reload()',600);
					} */
				  }else{
					pub_alert_error(r.info);
				  }
			}
		
		});
	
	}
</script>
<script>
	function hideceng(){
		$('#pub_edit_bootbox').addClass('fade');$('#pub_edit_bootbox').addClass('hide');$('#pub_edit_bootbox').attr('tabindex','-1');
	}
</script>