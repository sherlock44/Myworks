
<section class="content-header">
	<h1>
		加盟店会员
		<small>加盟店会员详情</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">会员卡管理</a></li>
		<li class="active">加盟店会员</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">加盟店会员列表</h3>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<form action="<?=$this->url("card/crmrelated")?>" method="GET" class="input-group input-group-sm" style="padding-bottom:10px;">
							<input id="title" name="title" style="width: 200px;" class="form-control"type="text" placeholder="加盟店名称" value="<?=$title?>">
							<input type="submit" class="btn btn-primary btn-sm" style="margin-left: 10px;"  value="搜索">
						</form>
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th >所属加盟商</th>
									<?foreach($cardType as $v){?>
									<th ><?=$v?>已开通数量</th>
									<?}?>
								</tr>
							</thead>
							<tbody>
								<?foreach($franchisee as $val){?>
								<tr>
									<td><?=$val['title']?></td>
									<?foreach($cardType as $k=>$v){?>
									<td><?=$val['passnum'.$k]?></td>
									<?}?>
								</tr>
								<?}?>	
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
