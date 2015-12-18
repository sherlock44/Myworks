<section class="content-header">
	<h1>
		单品管理
		<small>回收站</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">商品管理</a></li>
		<li class="active">单品管理</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">回收站商品列表</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<form action="<?=$this->url("goods/del_lists")?>" method="GET" class="input-group input-group-sm" style="padding-bottom:10px;" >
							<select name='pagenum' class="form-control" style="width: 120px;">					
								<option value='10' <?=isset($_GET['pagenum'])&&$_GET['pagenum']==10?"selected":""?> >每页显示条数</option>
								<option value='20' <?=isset($_GET['pagenum'])&&$_GET['pagenum']!==''&&$_GET['pagenum']==20?"selected":""?>>20</option>							 
								<option value='50' <?=isset($_GET['pagenum'])&&$_GET['pagenum']==50 ?"pagenum":""?>>50</option>
								<option value='100' <?=isset($_GET['pagenum'])&&$_GET['pagenum']==100 ?"pagenum":""?>>100</option>
							</select>
							<select name='categoryuuid' class="form-control" style="width: 120px;margin-left: 10px;">
								<option value='' <?=isset($_GET['categoryuuid'])&&$_GET['categoryuuid']==''?"selected":""?> >商品分类</option>
								<?=$trees?>
							</select>
							<select name='branduuid' class="form-control" style="width: 120px;margin-left: 10px;">
								<option value='' <?=isset($_GET['branduuid'])&&$_GET['branduuid']==''?"selected":""?> >全部品牌</option>
								<?foreach($brand as $val){?>
								<option value='<?=$val['uuid']?>' <?=isset($_GET['branduuid'])&&$_GET['branduuid']==$val['uuid']?"selected":""?> ><?=$val['title']?></option>
								<?}?>
							</select>
							<input id="userphone" name="userphone" style="width: 180px; margin-left: 10px;" class="form-control" type="text" placeholder="商品名称/条形码" value="<?=$userphone?>">
							<button style="margin-left: 10px;" type="submit" class="btn btn-primary btn-sm">搜索</button>
						</form>
						<table class="table table-bordered table-hover">
							<thead>
								<tr >
									<th >商品类别</th>
									<th>商品名称</th>
									<th >图片</th>
									<th>商品条码</th>
									<th >保质期(月)</th>		
									<th >单品重量</th>
									<th >装箱规格</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<?foreach ($re as $value) {?>
								<tr>
									<td><?=$value['fctitle']?></td>
									<td><?=$value['title']?></td>
									<td><img width=25 height=25   src="<?=empty($value["imgpath"])?"/public/assets/sysadmin/img/200_200_no_image.gif":$value["imgpath"]?>"></td>
									<td><?=$value['barcode']?></td>
									<td><?=$value['shelflife']?></td>
									<td><?=$value['weight']?>g/<?=$value['specs']?></td>	
									<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>	
									<td>
										<a href="javascript:pub_alert_confirm(this,'确定要恢复吗？','<?=$this->url("goods/editisdel")?>?id=<?=$value["id"]?>');" class="btn btn-xs btn-danger" title="恢复">恢复</a>
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
