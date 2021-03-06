<div id="main">
    <div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">订货管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">订货商品列表</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="fa fa-close"></i></a>
	</div>
</div>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/chosen/chosen.css">
<script src="/public/assets/sysadmin/js/plugins/chosen/chosen.jquery.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/jquery.dataTables.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/TableTools.css">
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/TableTools.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColReorder.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColVis.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.columnFilter.js"></script>

<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>订货流程
				</h3>				
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("newcash/insertplan")?>'  id="login" name="login" method='post'>
					<div class="control-group" style="height:45px;background-color:white;text-align:center;padding-top:10px;">
						<?foreach($this->conf['orderstatus'] as $k=>$v){?>
								<?if($k<0){continue;}?>
								<?if($order['status']==$k){?>
								<span style="color:red;"><?echo ($k+1).".$v";?></span>
								<?}else{?>
								<?echo ($k+1).".$v";?>
								<?}?>
							<?}?>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
        <div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					订货商品列表
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        						<tr>
							
							<th width="10%">商品名称</th>
							<th width="10%">商品编号</th>
							
							
							
							<th width="10%">价格</th>
														
							<th width="10%">库存</th>							
							
							<th width="15%">订购数量</th>
							<th width="15%">报损数量</th>
						
							
					
						
						</tr>
        					</thead>
                            <?
                                foreach($re as $key=>$value){
                            ?>
                            <tr>
							
							<td><?=$value['title']?>&nbsp;
							<?if(empty($value["imgpath"])){?>
								<img width=25 height=25   src="/public/assets/sysadmin/img/default.png">
								<?}else{?>
								<a href="<?=$value["imgpath"]?>" target="_black">
								<img width=25 height=25   src="<?=$value["imgpath"]?>">
								</a>
								<?}?>
							</td>
							<td><?=$value['barcode']?></td>
							<td><?=$value['buyprice']?></td>	
							
							<td><?=$value['number']?></td>
							<td><?=$value['buynum']?></td>
							<td>
							<input type="text" id="goodsnum_<?=$value['id']?>" name="goodsnum_<?=$value['id']?>" onchange="changenum(<?=$value['id']?>,<?=$value['buynum']?>)"  value="<?=$value['lossnum']?>" class="span8" data-rule-required="true" data-rule-number="true" data-rule-minlength="1" placeholder="只能填数字">
							</td>
							
							
													
							</tr>
                            <?
                                }
                            ?>
        				</table>
					
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
    	<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>
				</h3>
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate'	action=''  id="login" name="login" method='post'>
					<div class="control-group">
						<label for="mobile" class="control-label">加盟商名称</label>
						<div class="controls">
							<?=$userinfo['truename']?>
						</div>
					</div>
					
					<div class="control-group">
						<label for="mobile" class="control-label">联系方式</label>
						<div class="controls">
							<?=$userinfo['mobile']?>
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
	//报损数量
	function changenum(id,buynum){
		var num	=	$("#goodsnum_"+id).val();
		if(isNaN(num)){return false;}
		if(num>buynum){pub_alert_error("报损数量不能大于购买数量");return false;}
		if(!confirm("确认修改报损数量?")){
			return false;
		}
		$.ajax({
			url:"<?=$this->url('purchase/updatelossnum')?>",
			data:"id="+id+"&lossnum="+num,
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
//返回列表
	function returnList(){
		window.location.href='<?=$this->url("purchase/orderdeliver")?>';
	}

</script>