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
			<a href="">采购计划列表</a>
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
<!--div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>采购流程
					
				</h3>				
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("buyer/insertplan")?>'  id="login" name="login" method='post'>
					<div class="control-group" style="height:45px;background-color:white;text-align:center;padding-top:10px;">
						<?foreach($this->sysconf['purchasestatus'] as $k=>$v){?>
								<?if($k<0){continue;}?>
								<?if($re['status']==$k){?>
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
</div-->

   <div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					<?foreach($plan as $k=>$val){?>
								<a href="<?=$this->url('buyer/housestorelist',array('ordernum'=>$ordernum,'planid'=>$val['id']))?>" class="btn btn-danger" style="color:white;background:<?if($plantag==$val['id']){?>red<?}else{?>blue<?}?> none repeat scroll 0 0"><?=$val['title']?></a>&nbsp;|&nbsp;
							<?}?>
					
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding" style="overflow: auto;">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					<form   class='form-horizontal form-bordered form-validate' id="formmoney"	action='<?=$this->url("buyer/cwpassgoods")?>'   method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							<th width="5%">全选<input type="checkbox" selected="true" id="checkboxtag" onclick="boxcheck()"></th>
							<th width="10%">名称</th>
							<th width="8%">条码</th>
							<th width="4%">类型</th>
							<th width="4%">单品单位</th>
							<th width="5%">单品重量</th>
							<th width="5%">装箱量</th>
							
							<th width="5%">保质期(月)</th>
								
							<th width="5%">计划采<br>购数量</th>
							<th width="7%">实到数量</th>
							<th width="7%">总箱数</th>
							<th width="7%">运费(元)</th>
							<th width="7%">提货费(元)</th>
							<th width="7%">成本价(元)</th>
							<th width="8%">保质期质</th>
							<th width="8%">破损数量</th>
							<th width="8%">短装数量</th>
							<th width="8%">溢装数量</th>
							<th width="5%">状态</th>
							</tr>
        					</thead>
							<?if($plantag>0){?>
                            <?
                                foreach($goodsstore as $key=>$val){
								$n	=	count($val['time'])?count($val['time']):1;
                            ?>
							<?foreach($val['time'] as $ke=>$ve){?>
                            <tr>
								<?if($ke==0){?>
							<td rowspan="<?=$n?>">
							<?if($val['cwstatus']==0){?>
							<input type="checkbox" class="ckbox" value="<?=$val['id']?>" name="ids[]" selected='<?if($val['cwstatus']==1){echo "true";}else{echo "false";}?>' >
							<?}?>
							</td>
							<td rowspan="<?=$n?>"><?=$val['title']?>
							<input type="hidden" name="id[]" value="<?=$val['id']?>">
							
							
							
							<input type="hidden" name="cartid[]" value="<?=$val['cartid']?>">
							</td>
							<td rowspan="<?=$n?>">
							<?if(!empty($val['barcode'])){echo $val['barcode'];}?>
							</td>
							<td rowspan="<?=$n?>"><?=$val['cashtype']?></td>
						<td rowspan="<?=$n?>">
							<?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
							<td rowspan="<?=$n?>"><?if(!empty($val['weight']) &&$val['weight']>0){echo $val['weight'];}?>g</td>
							<td rowspan="<?=$n?>">
							<?if(!empty($val['boxnum']) &&$val['boxnum']>0){echo $val['boxnum'];}?>
							</td>
							
							<td rowspan="<?=$n?>">
							<?if(!empty($val['shelflife']) &&$val['shelflife']>0){echo $val['shelflife'];}else{echo "无";}?>
							</td>
							
								
							<td rowspan="<?=$n?>"><?=$val['number']?><?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
							<td rowspan="<?=$n?>">
							<?echo $val['realnumber'];?><?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
							<td  rowspan="<?=$n?>">
							<?echo $val['box'];?>
							</td>
							
							<td rowspan="<?=$n?>">
							<input type="text" name="thmoney_<?=$val['id']?>"  class="span8" style="width:100%" value="<?if(!empty($val['thmoney'])){echo $val['thmoney'];}?>" >
							</td>
							<td rowspan="<?=$n?>">
							<input type="text" name="yunfei_<?=$val['id']?>"  class="span8" style="width:100%" value="<?if(!empty($val['yunfei'])){echo $val['yunfei'];}?>" >
							</td>
							<td rowspan="<?=$n?>">
							<input type="text" name="chengbuprice_<?=$val['id']?>"  class="span8" style="width:100%" value="<?if(!empty($val['chengbuprice'])){echo $val['chengbuprice'];}?>" >
							</td>
							<?}?>
							<td>
							<?if($planrow['status']>1){ if($ve['productendtime']){echo date("Y-m-d",$ve['productendtime']);}else{echo "--";}}?>
							</td>
							<td>
							<?if($planrow['status']>1){echo $ve['puoshunnum'];}?>
							</td>
							<td>
						<?if($planrow['status']>1){echo $ve['duanzhuangnum'];}?>
							</td>
							<td>
							<?if($planrow['status']>1){echo $ve['yizhuangnum'];}?>
							</td>
							<?if($ke==0){?>
							<td rowspan="<?=$n?>">
								
							<?if($val['cwstatus']==0){echo "财务未审核";}else if($val['cwstatus']==1){echo "待入库";}else{echo "已入库";}?>
							</td>
							<?}?>
							</tr>
							
							<?}?>
                            <?
                                }
                            ?>
							<tr>
							<td>采购入库备注</td>
							<td colspan="11"><?=$planrow['remark']?></td>
							</tr>
							<tr>
							<td>库房核验备注</td>
							<td colspan="11"><?=$planrow['houseremark']?></td>
							</tr>
							<tr>
							<td colspan="12" style="text-align:center;">
								
							
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="button" class="btn btn-primary" value="提交所选商品" onclick='formtjmoney()'>	
							
							
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="button" class="btn btn-primary" value="商品审核完成,等待入库" onclick='formtjnext()'>	
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>	
							</td>
							</tr>
							<?}?>
							
        				</table>
						<input type="hidden" value="<?=$re["id"]?>" name="applyid" >
						<input type="hidden" value="<?=$plantag?>" name="planid" >
						</form>		
						<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
						
						        
						
						</div>
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
    
	
	
    </div>
</div>
<script>
	//提交表单
	function formtjmoney(){
		var num	=	$(".ckbox:checked").length;
		if(num==0){
			alert("未选择商品");return false;
		}
		if(confirm("确认提交所选商品，等待库房入库?")){
		$("#formmoney").attr('action',"/index.php/iManage/buyer/cwpassgoods");
			$("#formmoney").submit();
		}
	}
	//表单提交2，
	function formtjnext(){
		if(confirm("确认商品核价已结束?")){ 
			$("#formmoney").attr('action',"/index.php/iManage/buyer/caiwucheckprice");
			$("#formmoney").submit();
		}
	
	}
	//
	function boxcheck(){
		if($("#checkboxtag").prop("checked")==true){
			 $(".ckbox").prop("checked", true);
		}else{
			$(".ckbox").prop("checked", false);
		}
	
	}
	function tjplan(applyid){
		$.ajax({
			data:"applyid="+applyid,
			url:"<?=$this->url('buyer/changestatus1')?>",
			dataType:"json",
			type:"post",
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

	
	function isPirce(s){
    s=s.trim();
    var p =/^[1-9](\d+(\.\d{1,2})?)?$/; 
    var p1=/^[0-9](\.\d{1,2})?$/;
    return p.test(s) || p1.test(s);
}
//返回列表
	function returnList(){
		window.location.href="<?=$this->url('buyer/applycaiwu')?>";
	}
</script>

