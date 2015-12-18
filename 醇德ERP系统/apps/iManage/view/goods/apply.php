					<div id="main">
			<div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="javascript:;">商品管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购管理</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="fa fa-close"></i></a>
	</div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
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
					<i class="icon-th-list"></i>
					采购列表
				</h3>
				<div class="actions">
					<a rel="tooltip" data-original-title="添加" href="<?=$this->url("goods/addapply")?>" class="btn btn-danger"><i class="icon-plus"></i></a>
				</div>
				
			</div>
			<div class="box-content nopadding">
				<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
				<div id="DataTables_Table_0_length" class="dataTables_length" style="height:36px;">				
					<form action="<?=$this->url("goods/apply")?>" method="GET"  id="bb">
					<div class="row-fluid"  style="width:1000px;height:5px;">
						
						<div class="span2 ">
                            <div class="control-group">                                
                                <div class="controls controls-row">
                                     <select name='status' id='status' class="input-block-level">					
									 <option value='' <?=isset($_GET['status'])&&$_GET['status']==''?"selected":""?> >全部审核状态</option>
									  <option value='0' <?=isset($_GET['status'])&&$_GET['status']!==''&&$_GET['status']==0?"selected":""?>>未审核</option>									 
									 <option value='1' <?=isset($_GET['status'])&&$_GET['status']==1 ?"selected":""?>>商家审核通过</option>
									 <option value='-1' <?=isset($_GET['status'])&&$_GET['status']==-1 ?"selected":""?>>商家审核不通过</option>
									 <option value='2' <?=isset($_GET['status'])&&$_GET['status']==2 ?"selected":""?>>系统审核通过</option>
									 <option value='-2' <?=isset($_GET['status'])&&$_GET['status']==-2 ?"selected":""?>>系统审核不通过</option>
									 </select>
                                </div>
                            </div>
                       </div>		
                       <div class="span2 ">
                            <div class="control-group">                                
                                <div class="controls controls-row">
                                     <select name='is_shely' id='is_shely' class="input-block-level">					
									 <option value='' <?=isset($_GET['is_shely'])&&$_GET['is_shely']==''?"selected":""?> >全部商品</option>
									  <option value='0' <?=isset($_GET['is_shely'])&&$_GET['is_shely']!==''&&$_GET['is_shely']==0?"selected":""?>>上架</option>									 
									<option value='1' <?=isset($_GET['is_shely'])&&$_GET['is_shely']=='1'?"selected":""?> >下架</option>
									 </select>
                                </div>
                            </div>
                       </div>					
						<div class="span3">
                            <div class="control-group">                                
                                <div class="controls controls-row">
                                     <input id="userphone" name="userphone" class="input-block-level" type="text" placeholder="商品名称/商品编号" value="<?=$userphone?>">                              	
                                    
                                </div>
                            </div>
                       </div>
                      
                        <div class="span1">                            
                                    <input type="submit" class="btn btn-primary" value="搜索">                             
                       </div>                       
				</div>
					
					
                   </form>
                   </div>
				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
					<thead>
						<tr>
							<th width="10%">商品编号</th>
							<th width="10%">商品名称<br/>拼音码</th>
							
							<th width="10%">商品图片</th>
							<th width="10%">商品分类</th>
							<th width="10%">成本价<br/>销售价<br/>折扣价</th>
							<th width="10%">供应商</th>							
							<th width="10%">库存</th>							
					
							<th width="10%">是否打折</th>
							<th width="10%">审核状态</th>
					
							<th width="20%">操作</th>
						</tr>
					</thead>
					<tbody>
						<?foreach ($result as $value) {?>
						<tr>
							<td><?=$value['barcode']?></td>
							<td><?=$value['title']?><br/><?=$value['pingyincode']?></td>
							
							
							<td>
							<?if($value["imgpath"]){?>
								<img width=50 height=50   src="<?=empty($value["imgpath"])?"/public/assets/sysadmin/img/200_200_no_image.gif":$value["imgpath"]?>">
							  <?}else{?>
							    <img  width=50 height=50  src="/public/assets/sysadmin/img/200_200_no_image.gif">
							    <?}?>
							</td>
							<td><?=$value['fctitle']?></td>
							<td><?=$value['costprice']?><br/><?=$value['price']?><br/><?=$value['discountprice']?></td>	
							<td><?=$value['supplier']?></td>
							<td><?=$value['number']?></td>
							<td><?switch ($value['isdiscount']){
								case 0:
									echo "<span class='label label-red'>不打折</span>";
									break;
								case 1:
									echo "<span class='label label-success'>已打折</span>";
									break;

							}?></td>				
							<td><?switch ($value['status']){
								case 0:
									echo "<span class='label label-red'>禁用</span>";
									break;
								case 1:
									echo "<span class='label label-success'>正常</span>";
									break;

							}?></td>
						
							<td>
								<a data-original-title="修改" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('goods/editshop')?>?id=<?=$value["id"]?>"><i class="fa fa-sign-out"></i></a>
							
							
								<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("goods/shopdel")?>?id=<?=$value["id"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-close"></i></a>
								
							</td>
						</tr>
					<?}?>	
					</tbody>
				</table>
				<?=$pageHtml?>
			</div>
			</div>
		</div>
	</div>
</div>
</div></div>