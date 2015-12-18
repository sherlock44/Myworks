<section class="content-header">
	<h1>
		商品管理
		<small>单品信息管理</small>
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
					<h3 class="box-title">商品列表</h3>
					<div class="box-tools pull-right">
						<a href="<?=$this->url("goods/addshop")?>" class="btn btn-default btn-sm"> <i class="fa fa-plus"></i>
							添加
						</a>
						<a href="<?=$this->url("index/goodsout")?>" class="btn btn-default btn-sm"> <i class="fa fa-cloud-upload"></i></i>
							商品导出
						</a>
						<a href="<?=$this->url("index/pararegoods")?>" class="btn btn-default btn-sm"> <i class="fa fa-cloud-upload"></i></i>
							加盟商商品对比
						</a>
						<a href="<?=$this->url("goods/goodsin")?>" class="btn btn-default btn-sm"> <i class="fa fa-cloud-upload"></i></i>
							商品导入
						</a>
						 <a onclick="sycntopshop()" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i>
							同步到商城
						</a> 
						<a href="<?=$this->url("goods/changeshopcategory")?>"  class="btn btn-default btn-sm">
							<i class="fa fa-edit"></i>
							批量修改商品分类
						</a>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<form action="<?=$this->url("goods/lists")?>" method="GET" class="input-group input-group-sm" style="padding-bottom:10px;" >
							<select name='pagenum' class="form-control" style="width: 120px;">					
								<option value='10' <?=isset($_GET['pagenum'])&&$_GET['pagenum']==10?"selected":""?> >每页显示条数</option>
								<option value='20' <?=isset($_GET['pagenum'])&&$_GET['pagenum']!==''&&$_GET['pagenum']==20?"selected":""?>>20</option>							 
								<option value='50' <?=isset($_GET['pagenum'])&&$_GET['pagenum']==50 ?"pagenum":""?>>50</option>
								<option value='100' <?=isset($_GET['pagenum'])&&$_GET['pagenum']==100 ?"pagenum":""?>>100</option>
							</select>
							<select name='status' class="form-control" style="width: 120px;margin-left: 10px;">					
								<option value='' <?=isset($_GET['status'])&&$_GET['status']==''?"selected":""?> >全部审核状态</option>
								<option value='0' <?=isset($_GET['status'])&&$_GET['status']!==''&&$_GET['status']==0?"selected":""?>>下架</option>							 
								<option value='1' <?=isset($_GET['status'])&&$_GET['status']==1 ?"selected":""?>>上架</option>
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
									<th>商品类别</th>
									<th>商品名称</th>
									<th>图片</th>
									<th>商品条码</th>
									<th>保质期(月)</th>		
									<th>单品重量</th>
									<th>装箱规格</th>
									<th>状态</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<?foreach ($re as $value) {?>
								<tr>
									<td><?=$value['fctitle']?></td>
									<td><?=$value['title']?></td>
									<td><a href="<?=$value["imgpath"]?>" target="_black"><img width=25 height=25   src="<?=empty($value["imgpath"])?"/public/assets/sysadmin/img/default.png":$value["imgpath"]?>"></a></td>
									<td><?=$value['barcode']?></td>
									<td><?=$value['shelflife']?></td>
									<td><?=$value['weight']?>g/<?=$value['specs']?></td>	
									<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>	
									<td><?switch ($value['status']){
										case 0:
										echo "<span class='label label-warning'>下架</span>";
										break;
										case 1:
										echo "<span class='label label-success'>上架</span>";
										break;
									}?></td>
									<td>
										<a class="btn btn-xs btn-success" href="<?=$this->url('goods/editshop')?>?id=<?=$value["id"]?>"><i class="fa fa-edit"></i></a>
										<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("goods/shopdel")?>?id=<?=$value["id"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-trash"></i></a>
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
<script>
	function sycntopshop()
	{
		$.ajax({
			data:"1=1",
			type:"post",
			url:"<?=$this->url('goods/ecsync')?>",
			dataType:"json",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
				}else{
					pub_alert_error(r.info);
				}
			}
		});
	}

	function sycntofshop() {
		$.ajax({
			data:"1=1",
			type:"post",
			url:"<?=$this->url('goods/posspsync')?>",
			dataType:"json",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
				}else{
					pub_alert_error(r.info);
				}
			}
		});
	}
</script>