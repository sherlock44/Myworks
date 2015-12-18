<link rel="stylesheet" href="/public/adminlte/plugins/daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="/public/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap time picker -->
<script src="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<section class="content-header">
	<h1>
		未完成退货
		<small>未完成退货</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> ERP系统</a></li>
		<li><a href="#">退货管理</a></li>
		<li class="active">未完成退货</li>
	</ol>
</section>
<section class="content">
	<div class="box box-default" >
		<div class="box-header with-border">
			退货流程和当前状态
		</div>
		<div class="box-body">
			<div class="form-group" style="height:45px;background-color:white;text-align:center;padding-top:10px;">
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
		<?$url=$this->url("orderback/houseupdatebackgoods");$colspannum=10;?>
		<?if($order['backstatus']==2 && $order['housestatus']==1){?>
		<?$url=$this->url("orderback/houseupdatebackgoodspeihuo");$colspannum=11;?>
		<?}?>
		<?if($order['backstatus']==5){?>
		<?$url=$this->url("orderback/houseinsert");$colspannum=10;?>
		<?}?>
		<form class="form-validate form-confirm" action='<?=$url?>'  id="logins" name="logins" method='post'>
			<div class="box-body">
				<table class="table table-hover table-nomargin table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
					<thead>
						<tr>
							<th >商品分类</th>
							<th >商品名称</th>
							<th >图片</th>
							<th >商品条码</th>
							<th >保质期(月)</th>
							<th >重量</th>
							<th >保质期至</th>											
							<th >装箱规格</th>
							<th >订购数量</th>										
							<th >退货数量</th>
							<?if($order['backstatus']==2 && $order['housestatus']==0){?>
							<th>实到数量</th>
							<?}else{?>
							<th >实到数量</th>
							<?}?>
							<?if($order['backstatus']==2 && $order['housestatus']==1){?>
							<th>操作</th>
							<?}?>
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
						<td><?if(empty($value['shelflife'])){echo '--';}else{echo date("Y-m-d",empty($value['productontime'])?time():$value['productontime']);}?></td>	
						<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>
						<td><?=$value['buynum']?>箱</td>			
						<td><?=$value['backnum']?>箱</td>
						<td>
							<?if($order['backstatus']==2 && $order['housestatus']==0){?>
							<div class="input-group input-group-sm">
								<input type="text" id="goodsnum_<?=$value['ofid']?>" name="goodsnum_<?=$value['ofid']?>"   value="<?=empty($value['realbacknum'])?'':$value['realbacknum']?>" class="form-control" data-rule-required="false" data-rule-number="false" data-rule-minlength="1" placeholder="只能填数字">
								<span class="input-group-btn">
									<button class="btn btn-success" style="font-weight: bold;" type="button">箱</button>
								</span>
								<!-- <span class="input-group-addon">箱</span> -->
							</div>
							<input type="hidden" name="ofid[]" value="<?=$value['ofid']?>">
							<input type="hidden" name="goodsid_<?=$value['ofid']?>" value="<?=$value['id']?>">
							<input type="hidden" name="price_<?=$value['ofid']?>" value="<?=$value['buyprice']?>">
							<input type="hidden" name="backnum_<?=$value['ofid']?>" value="<?=$value['backnum']?>">
							<?}else{?>
							<?=$value['realbacknum']?>箱
							<?}?>
						</td>
						<?if($order['backstatus']==2 && $order['housestatus']==1){?>
						<td>
							<input type="button"  onclick="javascript:window.open('<?=$this->url("orderback/preparegoods",array("id"=>$value["ofid"],"ordernum"=>$value["ordernum"]))?>','','toolbar=false,status=false,menubar=false,location=false,directions=false,width=800,height=600,scrollbars=yes')"  class="btn btn-primary btn-sm" value="验货">
						</td>		
						<?}?>
					</tr>
					<?}?>
					<tr>
						<td>退货订单号</td>
						<td colspan="<?=$colspannum?>"><?=$ordernum?></td>
					</tr>
					<tr>
						<td>审批人</td>	
						<td colspan="<?=$colspannum?>">
							<?=!empty($order) ? $order['truename']: ''?>
						</td>
					</tr>
					<tr>
						<td>当前发货状态</td>	
						<td colspan="<?=$colspannum?>">
							<?if($order['orderbackstatus']==1){echo "未发货";}else{echo "已发货";}?>
						</td>
					</tr>
					<tr>
						<td>备注</td><td colspan="<?=$colspannum?>"><?=!empty($order) ? $order['orderbackremark']: ''?></td>
					</tr>
					<?if($order['backstatus']>=4){?>
					<tr>
						<td>复核备注</td>	<td colspan="10"><?=!empty($order) ? $order['backremarkfh']: ''?></td>
					</tr>
					<?}?>
					<?if($order['backstatus']>=5){?>
					<tr>
						<td>财务备注</td>	<td colspan="<?=$colspannum?>"><?=!empty($order) ? $order['backremarkcw']: ''?></td>
					</tr>
					<?}?>
					<?if(!empty($houseinfo) && !empty($houseinfo['yanhuoname'])){?>
					<tr>
						<td colspan="<?=$colspannum+1?>">
							验货员:<?=!empty($houseinfo) ? $houseinfo['yanhuoname']: ''?>&nbsp;&nbsp;
							验货时间:<?=!empty($houseinfo) ? date("Y-m-d",$houseinfo['yanhuotime']): ''?>
							&nbsp;&nbsp;
							备注：<?=!empty($houseinfo) ? $houseinfo['remark']: ''?>
							&nbsp;&nbsp;
						</td>
					</tr>
					<?}?>
					<?if(!empty($houseinfo) && !empty($houseinfo['yanhuoname'])){?>
					<tr>
						<td colspan="<?=$colspannum+1?>">
							入库员:<?=!empty($houseinfo['instorename']) ? $houseinfo['instorename']: ''?>&nbsp;&nbsp;
							入库时间:<?=!empty($houseinfo['instoretime']) ? date("Y-m-d",$houseinfo['instoretime']): ''?>
							&nbsp;&nbsp;
							备注：<?=!empty($houseinfo) ? $houseinfo['instoreremark']: ''?>
						</td>
					</tr>
					<?}?>
					
						<?if(!empty($houseinfo) && !empty($houseinfo['filetitle'])){?>
						<tr>
						<td>签收单</td>	
						<td colspan="<?=$colspannum?>">
							<a href="<?=empty($houseinfo['filepath'])?'':$houseinfo['filepath']?>" target="_black"><?=empty($houseinfo['filetitle'])?"":$houseinfo['filetitle']?></a>
						</td>
					</tr>
					<?}?>
					<?if($order['backstatus']==2  && $order['housestatus']==0){?>
					<tr>
						<td>验货结果</td>	
						<td colspan="<?=$colspannum?>">
							<select name="data[results]" style="width:120px;" class="form-control">
								<option value="1">通过</option>
								<option value="2">实到数量与退货数量不匹配</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>备注</td>
						<td colspan="<?=$colspannum?>"><textarea  rows="3" name="data[remark]" style="width:500px;" class="form-control"></textarea></td>
					</tr>
					<?}?>
					<?if($order['backstatus']==2   && $order['housestatus']==1){?>
					
					<tr>
						<td colspan="<?=$colspannum+1?>">
						操作员:
						<?=$this->info['truename']?>
						&nbsp;&nbsp;&nbsp;&nbsp;
						入库员:
						<select name="data[yanhuoid]" class="span8">
							<?foreach($user as $k=>$val){?>
							<option value="<?=$val['id']?>" <?if(!empty($logistics['yanhuoid']) &&  $val['id']==$logistics['yanhuoid']){echo "selected";}?>><?=$val['truename']?></option>
							<?}?>
							</select>
							&nbsp;&nbsp;&nbsp;&nbsp;
							验货日期
							 <input type="text" name="data[yanhuotime]" id="yanhuotime" value="<?=empty($logistics['yanhuotime'])?'':date('Y-m-d',$logistics['yanhuotime'])?>" class="input-medium datepick valid" data-rule-required="true" data-rule-minlength="1">
						</td>
						</tr>
						<tr>
						<td>上传签收单</td>	
						<td colspan="<?=$colspannum?>">
							<input type="file" name="files"><a href="<?=empty($logistics['filepath'])?'':$logistics['filepath']?>" target="_black"><?=empty($logistics['filetitle'])?"":$logistics['filetitle']?></a>
						</td>
					</tr>
					<tr>
						
							<td>备注</td>	<td colspan="<?=$colspannum?>"><textarea name="data[remark]" class="form-control"><?=empty($logistics['remark'])?'':date('Y-m-d',$logistics['remark'])?></textarea></td>
						</tr>
					<?}?>
					
					
					
					
					<?if($order['backstatus']==5){?>
						<tr>
						<td colspan="<?=$colspannum+1?>">
						入库员:
						<select name="data[instoreid]" class="span2">
							<?foreach($user as $k=>$val){?>
							<option value="<?=$val['id']?>" ><?=$val['truename']?></option>
							<?}?>
							</select>
						&nbsp;&nbsp;&nbsp;&nbsp;
						验货员:
						<input type="text" name="data[instoretime]" id="instoretime" value="<?=empty($logistics['instoretime'])?'':date('Y-m-d',$logistics['instoretime'])?>" class="input-medium datepick valid" data-rule-required="true" data-rule-minlength="1">
						</td>
						</tr>
						<tr>
						
							<td>入库备注</td>	<td colspan="<?=$colspannum?>"><textarea  rows="3" name="remark" class="form-control"></textarea></td>
						</tr>
						<tr>
						
							<td colspan="<?=$colspannum?>" style="text-align:center;"> 
							<input type="submit"    class="btn btn-primary" value="入库完成,提交">&nbsp;&nbsp;
							<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>		
							</td>
						</tr>
					<?}?>
				</table>
			</div>
			<?if($order['backstatus']==2   && $order['housestatus']==0){?>
			<div class="box-footer">
						<input type="submit" class="btn btn-success" value="提交" >					
						<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>		
			</div>	
			<?}?>	
			<?if($order['backstatus']==2   && $order['housestatus']==1){?>
				<div class="box-footer">
						<input type="submit" class="btn btn-success" value="验货完成,提交" >					
						<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>					
				</div>	
			<?}?>
			<input type="hidden" value="<?=$ordernum?>" name="ordernum">
						<input type="hidden" value="<?=$order['id']?>" name="id">		
		</form>
	</div>
	<?if($order['backstatus']==2 && $order['housestatus']==1){?>
	<form class="box box-default form-validate form-confirm" action='<?=$this->url("orderback/housecheckbackfirst")?>'  id="formtj1" name="login" method='post'>
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
	<?if($order['backstatus']==3){?>
	<form class="box box-default form-validate form-confirm" action='<?=$this->url("orderback/housecheckback")?>'  id="formtj1" name="login" method='post'>
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
	<?if($order['backstatus']==8){?><!--未用-->
	<form class="box box-default form-validate form-confirm" action='<?=$this->url("orderback/houseinsertback")?>'  id="formtj1" name="login" method='post'>
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
		window.location.href='<?=$this->url("orderback/orderhouselists")?>';
	}
function formtj(){
		if(confirm("确认提交？")){
			$("#formtj").submit();
		}
	}
function formtjs(){
		if(confirm("确认提交？")){
			$("#formtjs").submit();
		}
	}
</script>
