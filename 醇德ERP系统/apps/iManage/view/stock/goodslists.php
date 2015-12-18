<section class="content-header">
	<h1>
		当前库存管理
		<small>当前商品库存情况</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">库存管理</a></li>
		<li class="active">当前库存管理</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">当前库存列表</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<form action="<?=$this->url("stock/goodslists")?>" method="GET" class="input-group input-group-sm" style="padding-bottom:10px;">
							<select name='pagenum' id='pagenum' class="form-control" style="width: 120px;">					
								<option value='10' <?=isset($_GET['pagenum'])&&$_GET['pagenum']==10?"selected":""?> >每页显示条数</option>
								<option value='20' <?=isset($_GET['pagenum'])&&$_GET['pagenum']!==''&&$_GET['pagenum']==20?"selected":""?>>20</option>							 
								<option value='50' <?=isset($_GET['pagenum'])&&$_GET['pagenum']==50 ?"pagenum":""?>>50</option>
								<option value='100' <?=isset($_GET['pagenum'])&&$_GET['pagenum']==100 ?"pagenum":""?>>100</option>
							</select>
							<select name='status' id='status' class="form-control" style="width: 120px;margin-left: 10px;">					
								<option value='' <?=isset($_GET['status'])&&$_GET['status']==''?"selected":""?> >全部审核状态</option>
								<option value='0' <?=isset($_GET['status'])&&$_GET['status']!==''&&$_GET['status']==0?"selected":""?>>下架</option>							 
								<option value='1' <?=isset($_GET['status'])&&$_GET['status']==1 ?"selected":""?>>上架</option>
							</select>
							<select name='categoryuuid' id='categoryuuid' class="form-control" style="width: 120px;margin-left: 10px;">
								<option value='' <?=isset($_GET['categoryuuid'])&&$_GET['categoryuuid']==''?"selected":""?> >商品分类</option>
								<?=$trees?>
							</select>
							<select name='branduuid' id='brandid' class="form-control" style="width: 120px;margin-left: 10px;">
								<option value='' <?=isset($_GET['branduuid'])&&$_GET['branduuid']==''?"selected":""?> >全部品牌</option>
								<?foreach($brand as $val){?>
								<option value='<?=$val['uuid']?>' <?=isset($_GET['branduuid'])&&$_GET['branduuid']==$val['uuid']?"selected":""?> ><?=$val['title']?></option>
								<?}?>
							</select>	
							<input id="userphone" name="userphone" class="form-control" style="width: 120px;margin-left: 10px;" type="text" placeholder="商品名称/条形码/编码" value="<?=$userphone?>">
							<input type="submit" class="btn btn-primary btn-sm" style="margin-left: 10px;" value="搜索">        
						</form>
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									
									<th >商品名称</th>
									<th >图片</th>
									<th >商品编码</th>
									<th >商品条码</th>
									<th >保质期(月)</th>		
									<th >单品重量</th>
									<th >装箱规格</th>
									<th>库存(箱)</th>
									<th>状态</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<?foreach ($re as $value) {?>
								<tr>
								
									<td><?=$value['title']?></td>
									<td><a href="<?=$value["imgpath"]?>" target="_black"><img width=25 height=25   src="<?=empty($value["imgpath"])?"/public/assets/sysadmin/img/default.png":$value["imgpath"]?>"></a></td>
									<td><?=$value['erpcode']?></td>
									<td><?=$value['barcode']?></td>
									<td><?=$value['shelflife']?></td>
									<td><?=$value['weight']?>g/<?=$value['specs']?></td>	
									<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>	
									<td><?=$value['number']?></td>	
									<td><?switch ($value['status']){
										case 0:
										echo "<span class='label label-warning'>下架</span>";
										break;
										case 1:
										echo "<span class='label label-success'>上架</span>";
										break;
									}?></td>
									<td>
										<a title="修改" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('stock/editshop')?>?id=<?=$value["id"]?>"><i class="fa fa-edit"></i></a>
										<a title="生产日期" rel="tooltip" class="btn btn-xs  btn-warning" href="<?=$this->url('stock/timelist')?>?uuid=<?=$value["uuid"]?>"><i class="fa fa-calendar"></i></a>
										<a title="商品仓位" rel="tooltip" class="btn btn-xs  btn-primary" href="<?=$this->url('stock/goodsstorelist')?>?goodsid=<?=$value["id"]?>"><i class="fa fa-check-square-o"></i></a>
									</td>
								</tr>
								<?}?>	
							</tbody>
						</table>
						<div class="row">
							<?=$pageHtml?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>
