<section class="content-header">
	<h1>
		临期预警
		<small>临期预警商品</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">库存管理</a></li>
		<li class="active">临期预警</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">临期预警商品列表</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<form action="<?=$this->url("earlywarning/Beoverdue")?>" method="GET" class="input-group input-group-sm" style="padding-bottom:10px;">
							<select name='categoryuuid' id='categoryuuid' class="form-control" style="width: 120px;">
								<option value='' <?=isset($_GET['categoryuuid'])&&$_GET['categoryuuid']==''?"selected":""?> >商品分类</option>
								<?=$trees?>
							</select>
							<select name='branduuid' id='brandid' class="form-control" style="width: 120px;margin-left: 10px;">
								<option value='' <?=isset($_GET['branduuid'])&&$_GET['branduuid']==''?"selected":""?> >全部品牌</option>
								<?foreach($brand as $val){?>
								<option value='<?=$val['uuid']?>' <?=isset($_GET['branduuid'])&&$_GET['branduuid']==$val['uuid']?"selected":""?> ><?=$val['title']?></option>
								<?}?>
							</select>
							<input id="userphone" name="userphone" class="form-control" style="width: 120px;margin-left: 10px;" type="text" placeholder="商品名称/商品编号" value="<?=$userphone?>">
							<input type="submit" class="btn btn-primary btn-sm" style="margin-left: 10px;" value="搜索"> 
						</form>
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>商品名称</th>
									<th>图片</th>
									<th>商品条码</th>
									<th>保质期(月)</th>
									<th >单品重量</th>
									<th>装箱规格</th>
									<th>库存</th>
									<th>预警天数</th>
									<th>保质期至</th>
									<th>剩余天数</th>
								</tr>
							</thead>
							<tbody>
								<?foreach ($re as $value) {?>
								<?
								$date=($value['endtime']-strtotime(date("Y-m-d")))/24/3600;
								$date	=	floor($date);	
								?>
								<tr style="<?if($date<0){?>color:red;<?}?>">
									<td><?=$value['title']?>&nbsp;</td>
									<td><img width=25 height=25   src="<?=$value["imgpath"]?>"></td>
									<td><?=$value['barcode']?></td>
									<td><?=$value['shelflife']?></td>
									<td><?=$value['weight']?>g/<?=$value['specs']?></td>
									<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>
									<td><?=$value['num']?>箱</td>
									<td><?=$value['beoverdue']?></td>
									<td><?=empty($value['endtime'])?"--":date("Y-m-d",$value['endtime'])?></td>
									<td><?if($date<0){?>已过期<?}else{?><?=$date?>天<?}?></td>
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
