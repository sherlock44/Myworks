<div id="main">
    <div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="javascript:;">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购商品列表</a>
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
        					采购商品列表
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							<th width="8%">商品分类</th>
							<th width="20%">商品名称</th>
							<th width="5%">图片</th>
							<th width="10%">商品条码</th>
							<th width="6%">保质期(月)</th>
							<th width="6%">重量</th>
							<th width="6%">采购价格</th>
							<th width="5%">装箱规格</th>	
							<th width="8%">保质期至</th>											
													
							<th width="10%">订购数量</th>
							</tr>
        					</thead>
                            <?
								$weights	=	0;
								$aprices	=	0;
								$anum	=	0;
                                foreach($re as $key=>$value){
								$weights+=$value['weights']*($value['buynum']-$value['realbacknum']);
								$aprices+=$value['allprice'];		
								$anum+=	$value['buynum']-$value['realbacknum'];								
                            ?>
                            <tr>
							<td><?=$value['fctitle']?></td>
							<td><?=$value['title']?></td>
							
								<td><a href="<?=$value["imgpath"]?>" target="_black"><img width=25 height=25   src="<?=$value["imgpath"]?>"></a></td>
							<td><?=$value['barcode']?></td>
							<td><?=!empty($value['shelflife'])?$value['shelflife']:'--'?></td>
							<td><?=$value['weight']?>g/<?=$value['specs']?></td>
							
							<td><?=$value['buyprice']?>元/<?=$value['specs']?></td>	
							<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>		
							<td  ><?if(empty($value['shelflife'])){echo '--';}else{echo date("Y-m-d",empty($value['productontime'])?time():$value['productontime']);}?></td>			
							<td>
							<?if($order['orderbackstatus']>0 && $order['backstatus']==6){?>
							<?=$value['buynum']-$value['realbacknum']?>
							<?}else{?>
							<?=$value['buynum']?>
							<?}?>
							箱</td>					
							</tr>
                            <?
                                }
								
                            ?>
							<tr>
							<td>合计</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><?=$weights?>kg</td>
							<td><?=$aprices?>元</td>
							<td></td>
							<td></td>
							<td><?=$anum?>箱</td>
						
							</tr>
        				</table>
						
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
    
	

<?if($logistics){?>
<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>物流信息
				</h3>
			</div>
			<div class="box-content nopadding">
			
		
				<form  class='form-horizontal form-bordered form-validate' 	action=''  name="login" method='post'>
					<div class="control-group">
					<div style="width:25%;float:left;">
						<label for="mobile" class="control-label">打单员</label>
						<div class="controls">
                           
							<?=empty($logistics['truename'])?'':$logistics['truename']?>
                        </div>
                        </div>
						<div style="width:25%;float:left;">
						<label for="mobile" class="control-label" style="text-align:right;">配货员</label>
						<div class="controls">
                            
							<?foreach($user as $k=>$val){?>
							<?if(!empty($logistics['peihuoid']) &&  $val['id']==$logistics['peihuoid']){echo $val['truename'];}?>
							<?}?>
							
                        </div>
						</div>
					<div style="width:25%;float:left;">
						<label for="mobile" class="control-label" style="text-align:right;">核验员</label>
						<div class="controls">
                         
							<?foreach($user as $k=>$val){?>
							<?if(!empty($logistics['heyanid']) &&  $val['id']==$logistics['heyanid']){echo $val['truename'];}?>
						
							<?}?>
							

                        </div>
						</div>
						<div style="width:25%;float:left;">
						<label for="mobile" class="control-label" style="text-align:right;">发货人</label>
						<div class="controls">
						<?foreach($user as $k=>$val){?>
							<?if(!empty($logistics['fahuoid']) &&  $val['id']==$logistics['fahuoid']){echo $val['truename'];}?>
						
							<?}?>
                          

                        </div>
						</div>
					</div>
			
				
					
					
					
					
					<div class="control-group">
						<div style="width:34%;float:left;">
						<label for="mobile" class="control-label" >发货地物流公司名称</label>
						<div class="controls">
                            <?=empty($logistics['companystart'])?'':$logistics['companystart']?>

                        </div>
                        </div>
						<div style="width:33%;float:left;">
						<label for="mobile" class="control-label" style="text-align:right;">发货地物流公司电话</label>
						<div class="controls">
                          <?=empty($logistics['mobilestart'])?'':$logistics['mobilestart']?>

                        </div>
						</div>
					
						<div style="width:33%;float:left;">
						<label for="mobile" class="control-label" style="text-align:right;">发货地物流公司联系人</label>
						<div class="controls">
                            <?=empty($logistics['usernamestart'])?'':$logistics['usernamestart']?>

                        </div>
                        </div>
					</div>
					
					
					
					<div class="control-group">
						<div style="width:34%;float:left;">
						<label for="mobile" class="control-label">到达地物流公司名称</label>
						<div class="controls">
                           <?=empty($logistics['companyarrive'])?'':$logistics['companyarrive']?>

                        </div>
                        </div>
						<div style="width:33%;float:left;">
						<label for="mobile" class="control-label" style="text-align:right;">到达地物流公司电话</label>
						<div class="controls">
                           <?=empty($logistics['mobilearrive'])?'':$logistics['mobilearrive']?>

                        </div>
						</div>
					
						<div style="width:33%;float:left;">
						<label for="mobile" class="control-label" style="text-align:right;">到达地物流公司联系人</label>
						<div class="controls">
                            <?=empty($logistics['usernamearrive'])?'':$logistics['usernamearrive']?>
                        </div>
                        </div>
					</div>
					
					<div class="control-group">
					<div style="width:23%;float:left;">
						<label for="mobile" class="control-label">货物总件数</label>
						<div class="controls">
                           <?=empty($logistics['goodsnum'])?'':$logistics['goodsnum']?>

                        </div>
                        </div>
						<div style="width:23%;float:left;">
						<label for="mobile" class="control-label" style="text-align:right;">总重量</label>
						<div class="controls">
                           <?=empty($logistics['weight'])?'':$logistics['weight']?>

                        </div>
						</div>
						<div style="width:23%;float:left;">
						<label for="mobile" class="control-label" style="text-align:right;">物流费用</label>
						<div class="controls">
                            <?=empty($logistics['logisticscost'])?'':$logistics['logisticscost']?>元

                        </div>
						</div>
						<div style="width:31%;float:left;">
						<label for="mobile" class="control-label" style="text-align:right;">送货费用</label>
						<div class="controls">
                            <?=empty($logistics['sendmoney'])?'':$logistics['sendmoney']?>元
							&nbsp;&nbsp;&nbsp;到付<input type="checkbox" value="1" name="data[isarrivepay]" <?if(!empty($logistics['isarrivepay'])){echo "checked";}?> >
                        </div>
						</div>
						
					</div>
					
					<div class="control-group">
					<div style="width:50%;float:left;">
						<label for="mobile" class="control-label" >发货日期</label>
						<div class="controls">
                            <?=empty($logistics['senddate'])?'':date('Y-m-d',$logistics['senddate'])?>

                        </div>
						</div>
						<div style="width:50%;float:left;">
						<label for="mobile" class="control-label" style="text-align:right;">预计到达</label>
						<div class="controls">
                          <?=empty($logistics['maybearrivedate'])?'':date('Y-m-d',$logistics['maybearrivedate'])?>

                        </div>
						</div>
					<div style="width:50%;float:left;">
						<label for="mobile" class="control-label">物流单号</label>
						<div class="controls">
                           <?=empty($logistics['logisticsnumber'])?'':$logistics['logisticsnumber']?>

                        </div>
						</div>
						<div style="width:50%;float:left;">
						<label for="mobile" class="control-label" style="text-align:right;"> 物流车号</label>
						<div class="controls">
                           <?=empty($logistics['carnumber'])?'':$logistics['carnumber']?>

                        </div>
						</div>
					</div>
				
				
					<div class="control-group">
						<label for="mobile" class="control-label">备注</label>
						<div class="controls">
							<?=empty($logistics['remark'])?'':$logistics['remark']?>
						</div>
					</div>
				
				
					
				
		
					
				
				</form>
			</div>
		</div>
	</div>
</div>



<?}?>
	
	
	
<?if(in_array($order['status'],array(4))){?>
	<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>用户确认收货
				</h3>
			</div>
			<div class="box-content nopadding">
			<?$url=$this->url("purchase/updateorderstatus");?>
			
				<form  class='form-horizontal form-bordered form-validate' 	action='<?=$url?>'  id="formtj" name="login" method='post'>
					
				
					
					<div class="control-group">
						<label for="mobile" class="control-label">备注</label>
						<div class="controls">
							<textarea name="completeremark" class="span8"></textarea>
						</div>
					</div>
					
					<div class="control-group" style="display:none;">
						<label for="mobile" class="control-label">审核</label>
						<div class="controls">
							<select name="results">
							<option value="0">确认收货</option>
							<option value="1">货物漏发</option>
							<option value="2">货物损坏</option>
							<option value="3">货物丢失</option>
							</select>
						</div>
					</div>
					
					
					
		
					
				<input type="hidden" value="<?=$order['id']?>" name="id">
							<div class="form-actions">		
								<input type="button"  onclick="formtj();" id="butsure" class="btn btn-primary" value="提交">
						<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>					
						</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?}?>
	
		<div class="row-fluid">
	<div class="span12">
		<div class="box ">
			
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate' 	action=''  id="formtjs" name="login" method='post'>
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
		window.location.href='<?=$this->url("purchase/orderconfirm")?>';
	}
	function formtj(){
		if(confirm("确认提交？")){
			$("#butsure").attr('disabled',true);
			$("#formtj").submit();
			
			
		}
	}
</script>