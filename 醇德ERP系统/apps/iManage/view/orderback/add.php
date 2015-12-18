<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<section class="content-header">
	<h1>
		选择退货单
		<small>申请退货单</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> ERP系统</a></li>
		<li><a href="#">退货管理</a></li>
		<li class="active">选择退货单</li>
	</ol>
</section>
<section class="content">
	<div class="box box-default" >
		<div class="box-header with-border">
			退货流程和当前状态
		</div>
		<div class="box-body">
			<div class="control-group" style="height:45px;background-color:white;text-align:center;padding-top:10px;">
				<?foreach($this->conf['orderbackstatus'] as $k=>$v){?>
				<?if($k<0){continue;}?>
				<?if($order['backstatus']==$k){?>
				<span style="color:red;"><?echo ($k+1).".$v";?></span>
				<?}else{?>
				<?echo ($k+1).".$v";?>
				<?}?>
				<?}?>
			</div>
		</div>
		<div class="box-header with-border">
			请选择退货商品和数量
		</div>
		<form class="form-validate form-confirm" action='<?=$this->url("orderback/updatebackgoods")?>'  id="logins" name="logins" method='post'>
			<div class="box-body">
				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
					<thead>
						<tr>
							<th>商品分类</th>
							<th>商品名称</th>
							<th>图片</th>
							<th>商品条码</th>
							<th>保质期(月)</th>
							<th>重量</th>
							<th>采购价格</th>
							<th>保质期至</th>											
							<th>装箱规格</th>
							<th>订购数量</th>										
							<th width="130">退货数量</th>
						</tr>
					</thead>
					<?foreach($goods as $key=>$value){?>
					<tr>
						<td><?=$value['fctitle']?></td>
						<td><?=$value['title']?></td>
						<td><img width=25 height=25   src="<?=$value["imgpath"]?>"></td>
						<td><?=$value['barcode']?></td>
						<td><?=!empty($value['shelflife'])?$value['shelflife']:'--'?></td>
						<td><?=$value['weight']?>g/<?=$value['specs']?></td>
						<td><?=$value['buyprice']?>元/<?=$value['specs']?></td>	
						<td><?if(empty($value['shelflife'])){echo '--';}else{echo date("Y-m-d",empty($value['productontime'])?time():$value['productontime']);}?></td>	
						<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>
						<td><?=$value['buynum']?>箱</td>			
						<td>
							<?if($order['backstatus']==0 && $order['userid']==$this->info['id']){?>
							<div class="input-group input-group-sm">
								<input type="text"  onchange="changenum(<?=$value['ofid']?>)" id="goodsnum_<?=$value['ofid']?>" name="goodsnum_<?=$value['ofid']?>"   value="<?=empty($value['backnum'])?'':$value['backnum']?>" class="form-control" data-rule-required="false" data-rule-number="false" data-rule-minlength="1" placeholder="只能填数字">
								<span class="input-group-btn">
									<button class="btn btn-success" style="font-weight: bold;" type="button">箱<?if(!empty($val['realbacknum'])){?>(实到<?=$val['realbacknum']?>箱)<?}?></button>
								</span>
								<!-- <span class="input-group-addon">箱</span> -->
							</div>
							<input type="hidden" name="ofid[]" value="<?=$value['ofid']?>">
							<input type="hidden" name="goodsid_<?=$value['ofid']?>" value="<?=$value['id']?>">
							<input type="hidden" name="price_<?=$value['ofid']?>" value="<?=$value['buyprice']?>">
							<input type="hidden" name="buynum_<?=$value['ofid']?>" id="buynum_<?=$value['ofid']?>" value="<?=$value['buynum']?>">
							<?}else{?>
							<?=$value['backnum']?>箱
							<?}?>
						</td>
					</tr>
					<?}?>
					<tr>
						<td>退货订单号</td>	<td colspan="10"><?=$ordernum?></td>
					</tr>
					<?if($order['backstatus']==0  && $order['userid']==$this->info['id']){?>
					<tr>
						<td>审批人</td>	
						<td colspan="10">
							<select name="data[backdirectorid]" class="form-control" style="width:120px;">
								<?foreach($admin as $val){?>
								<option value="<?=$val['id']?>"><?=$val['truename']?></option>
								<?}?>
							</select>
						</td>
					</tr>
					<tr>
						<td>当前发货状态</td>	
						<td colspan="10">
							<select name="data[orderbackstatus]" class="form-control" style="width:120px;">
								<option value="1">未发货</option>
								<option value="2">已发货</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>备注</td>	
						<td colspan="10"><textarea class="form-control" style="width:500px;" rows="3" name="data[orderbackremark]"><?=!empty($order) ? $order['orderbackremark']: ''?></textarea></td>
					</tr>
					<?}else{?>
					<tr>
						<td>审批人</td>	
						<td colspan="10">
							<?=!empty($order) ? $order['truename']: ''?>
						</td>
					</tr>
					<tr>
						<td>当前发货状态</td>	
						<td colspan="10">
							<?if($order['orderbackstatus']==1){echo "未发货";}else{echo "已发货";}?>
						</td>
					</tr>
					<tr>
						<td>备注</td><td colspan="10"><?=!empty($order) ? $order['orderbackremark']: ''?></td>
					</tr>
					<?if($order['backstatus']>=4){?>
					<tr>
						<td>复核备注</td>	<td colspan="10"><?=!empty($order) ? $order['backremarkfh']: ''?></td>
					</tr>
					<?}?>
					<?}?>
				</table>
			</div>
			<?if($order['backstatus']==0  && $order['userid']==$this->info['id']){?>
			<div class="box-footer">
				<input type="hidden" value="<?=$ordernum?>" name="ordernum">
				<input type="hidden" value="0" name="id">
				<input type="submit" class="btn btn-success" value="提交" >					
				<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>		
			</div>
			<?}?>
		</form>
	</div>
	<?if($order['backstatus']==1  && $order['userid']==$this->info['id']){?>
	<form class="box box-default form-validate form-confirm" action='<?=$this->url("orderback/backorderreturnxs")?>'  id="formtj1" name="login" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">反审核</h3>
		</div>
		<div class="box-body row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="remark">备注</label>
					<textarea name="data[remark]" class="form-control" placeholder="(反审之后,可以修改退货信息)"></textarea>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<input type="hidden" value="<?=$order['id']?>" name="id">
			<input type="submit" class="btn btn-danger" value="反审">
			<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>				
		</div>
	</form>
	<?}?>
	<?if(($order['backstatus']==2 ||  $order['backstatus']==-1) && $order['backdirectorid']==$this->info['id']){?>
	<form class="box box-default form-validate form-confirm" action='<?=$this->url("orderback/directorcheckback")?>' id="formtj2" name="login" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">主管反审核</h3>
		</div>
		<div class="box-body row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="remark">备注</label>
					<textarea name="data[remark]" class="form-control" placeholder="(反审之后,可以修改退货信息)"></textarea>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<input type="hidden" value="<?=$order['id']?>" name="id">
			<input type="submit" class="btn btn-danger" value="反审">
			<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>	
		</div>
	</form>
	<?}?>
	<?if($order['backstatus']==1 && $order['backdirectorid']==$this->info['id']){?>
	<form class="box box-default form-validate form-confirm" action='<?=$this->url("orderback/directorcheck")?>'  id="formtj3" name="login" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">主管审批</h3>
		</div>
		<div class="box-body row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="remark">备注</label>
					<textarea name="data[remark]" class="form-control" placeholder="(反审之后,可以修改退货信息)"></textarea>
				</div>
				<div class="form-group">
					<label for="results">审核结果</label>
					<select name="data[results]" class="form-control">
						<option value="1">通过</option>
						<option value="0">不通过</option>
					</select>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<input type="hidden" value="<?=$order['id']?>" name="id">
			<input type="submit" class="btn btn-success" value="审批">
			<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>	
		</div>
	</form>
	<?}?>
	<?if($order['backstatus']==3 && $order['userid']==$this->info['id']){?>
	<form class="box box-default form-validate form-confirm" action='<?=$this->url("orderback/backorderfh")?>'  id="formtj4" name="login" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">复核</h3>
		</div>
		<div class="box-body row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="remark">备注</label>
					<textarea name="data[backremarkfh]" class="form-control" placeholder=""></textarea>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<input type="hidden" value="<?=$order['id']?>" name="id">
			<input type="submit" class="btn btn-success" value="提交">
			<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>	
		</div>
	</form>
	<?}?>
	<?if($log){?>
	<div class="box box-default">
		<div class="box-header">
			<h3 class="box-title">
				订单操作记录
			</h3>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-init">
					<thead>
						<tr>
							<th>序号</th>
							<th>审核人</th>
							<th>审核</th>
							<th>描术</th>							
							<th>审核时间</th>
						</tr>
					</thead>
					<?foreach($log as $ks=>$value){?>
					<tr>
						<td><?=$ks?></td>
						<td><?=$value['truename']?></td>
						<td><?=$value['results']?></td>
						<td><?=$value['remark']?></td>	
						<td><?=date("Y-m-d H:i:s",$value['created'])?></td>					
					</tr>
					<?}?>
				</table>
			</div>
		</div>
	</div>
	<?}?>
</section>
<script>
//返回列表
function returnList(){
	window.location.href='<?=$this->url("orderback/lists")?>';
}
function changenum(id){
	var goodsnum	=	$("#goodsnum_"+id).val()-0;
	var buynum	=	$("#buynum_"+id).val()-0;
	if(goodsnum>buynum){
		alert("退货数量不能大于购买数量");
		$("#goodsnum_"+id).val(0);
	}
}	
</script>
