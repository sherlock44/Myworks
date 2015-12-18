	<div id="main">
			<div class="container-fluid nopadding">

<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">退货管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href=""><?=!empty($re)?"修改退货单":"添加退货单"?></a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="fa fa-close"></i></a>
	</div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script><div class="row-fluid">


<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/chosen/chosen.css">
<script src="/public/assets/sysadmin/js/plugins/chosen/chosen.jquery.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datetimepicker/datetimepicker.css">
<script src="/public/assets/sysadmin/js/plugins/datetimepicker/datetimepicker.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datetimepicker/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="/public/assets/sysadmin/js/plugins/kindeditor/kindeditor-min.js"></script>
<link rel="stylesheet" href="/public/js/plugins/kindeditor/themes/default/default.css" />
<script src="/public/assets/sysadmin/js/plugins/fileupload/bootstrap-fileupload.min.js"></script>
		<div class="row-fluid" >
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>加盟商信息
				</h3>
				<div class="actions">
        					<a rel="tooltip"  href="javascript:void(0)" id="othermessage" onclick="javascript:if($('#otherdiv')[0].style.display=='none'){$('#otherdiv').show();$('#othermessage').html('-');}else{$('#otherdiv').hide();$('#othermessage').html('+');}"  class="btn btn-danger">+</a>
        				</div>
			</div>
			<div class="box-content nopadding" id="otherdiv" style="display:none;">
				<form  class='form-horizontal form-bordered form-validate'	action=''  id="login" name="login" method='post'>
					<div class="control-group">
						<label for="mobile" class="control-label">加盟商类型</label>
						<div class="controls">
							<?=$userinfo['supplytype']?>
						</div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">所属区域</label>
						<div class="controls">
							<?=$userinfo['pname']?>省-<?=$userinfo['cname']?>市
						</div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">地址</label>
						<div class="controls">
							<?=$userinfo['address']?>
						</div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">公司名称-电话</label>
						<div class="controls">
							<?=$userinfo['commname']?>-<?=$userinfo['commtel']?>
						</div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">负责人姓名-电话</label>
						<div class="controls">
							<?=$userinfo['truename']?>-<?=$userinfo['mobile']?>
						</div>
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
        					退货商品列表
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
					<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("orderback/updatebackgoods")?>'  id="logins" name="logins" method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        						<tr>
        								<th >商品分类</th>
										<th >商品名称</th>
										<th >图片</th>
										<th >商品条码</th>
										<th >保质期(月)</th>
										<th >重量</th>
										<th >采购价格</th>
										<th >保质期至</th>											
										<th >装箱规格</th>
										<th >订购数量</th>										
										<th >退货数量</th>
        						</tr>
        					</thead>
                            <?
                                foreach($goods as $key=>$value){
                                    ?>
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
            				<td><?=$value['backnum']?>箱</td>			
						
            						</tr>
                                    <?
                                }
                            ?>
							<tr>
								<td>退货订单号</td>	<td colspan="10"><?=$ordernum?></td>
								
							</tr>
							<tr>
								<td>当前发货状态</td>	
								<td colspan="10">
								
								<?if($order['orderbackstatus']==1){echo "未发货";}else{echo "已发货";}?>
								</td>
								
							</tr>
							<tr>
							
								<td>备注</td>	<td colspan="10"><?=!empty($order) ? $order['orderbackremark']: ''?></td>
							</tr>
        				</table>
					
						<input type="hidden" value="<?=$ordernum?>" name="ordernum">
						<input type="hidden" value="0" name="id">
						
						
							<div class="form-actions">
						<input type="submit" class="btn btn-primary" value="提交" >					
						<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>					
						
						</div>
						 </form>
        			</div>
        		</div>
        	</div>
        </div>

	<?if($order['backstatus']==1){?>
<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>反审
				</h3>
				
			</div>
			<div class="box-content nopadding" >
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("orderback/backorderreturnxs")?>'  id="formtj" name="login" method='post'>
					<div class="control-group">
						<label for="mobile" class="control-label">备注</label>
						<div class="controls">
							<textarea name="data[remark]" class="span8"></textarea>(反审之后,可以修改退货信息)
						</div>
					</div>
					
					
	
				
						<input type="hidden" value="<?=$order['id']?>" name="id">
							<div class="form-actions">		
								<input type="button"  onclick="formtj();"  class="btn btn-primary" value="提交">
								<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>					
										
									
						
						</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?}?>


</div>
</div>
</div>
<script>
//返回列表
	function returnList(){
		window.location.href='<?=$this->url("orderback/lists")?>';
	}
function formtj(){
		if(confirm("确认提交？")){
			$("#formtj").submit();
		}
	}
</script>
