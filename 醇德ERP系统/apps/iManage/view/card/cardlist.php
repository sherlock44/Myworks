<section class="content-header">
	<h1>
		会员卡列表
		<small>会员卡列表</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">会员卡管理</a></li>
		<li class="active">会员卡列表</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">会员卡列表</h3>
					<div class="box-tools pull-right">
						<a rel="tooltip" data-original-title="会员卡导出" href="<?=$this->url("card/cardout")?>" class="btn btn-default btn-sm"> 会员卡导出</a>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<form action="<?=$this->url("card/cardlist")?>" method="GET" class="input-group input-group-sm" style="padding-bottom:10px;">
							<select name='status' id='status' style="width: 120px;" class="form-control" >                 
								<option value='' <?=isset($_GET['status'])&&$_GET['status']==''?"selected":""?> >所有卡</option>
								<option value='1' <?=isset($_GET['status'])&&$_GET['status']==1?"selected":""?>>已激活卡</option>
								<option value='0' <?=isset($_GET['status'])&&$_GET['status']!==''&&$_GET['status']==0?"selected":""?>>未激活</option>
								<option value='-1' <?=isset($_GET['status'])&&$_GET['status']!==''&&$_GET['status']==-1?"selected":""?>>已挂失</option>
								<option value='2' <?=isset($_GET['status'])&&$_GET['status']!==''&&$_GET['status']==2?"selected":""?>>已冻结</option>
							</select>	
							<select name='cardtype' id='cardtype' style="width: 120px;margin-left: 10px;" class="form-control">                 
								<option value="">所有类型</option>
								<?foreach ($card as $key => $v) {?>
								<option value=<?=$key?>><?=$v?></option>
								<?}?>
							</select>   
							<input id="cardnum" name="cardnum" style="width: 120px;margin-left: 10px;" class="form-control" type="text" placeholder="卡号" value="<?=$cardnum?>">
							<input type="submit" class="btn btn-primary btn-sm" style="margin-left: 10px;"  value="搜索">
						</form>
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th width="40">#</th>
									<th>会员卡卡号</th>
									<th>会员卡类型</th>
									<th width="100">会员卡状态</th>
									<th width="100">操作</th>
								</tr>
							</thead>
							<tbody>
								<?if ($re!=='') {?>
								<?foreach ($re as  $value){?>
								<tr>
									<td><?=$value['id']?></td>
									<td><?=$value['cardnum']?></td>
									<td><?=$card[$value['cardtype']]?></td>
									<td>
										<?if($value['status']==1){?>
										<a title="冻结" class="label label-success" href="javascript:pub_alert_confirm(this,'确定要冻结吗？','<?=$this->url("card/changecardstatus")?>?id=<?=$value["id"]?>');">激活</a>
										<?}else if($value['status']==0){?>
										<span class='label label-primary'>未激活</span>
										<?}else if($value['status']==-1){?>
										<span class='label label-danger'>已挂失</span>
										<?}else{?>
										<span class='label label-warning'>冻结</span>
										<?}?>
										&nbsp;
									</td>
									<td>
										<?if ($value['status']==1) {?>
										<a data-original-title="查看详情" rel="tooltip" class="btn btn-xs btn-success " href="<?=$this->url('card/carddetail')?>?id=<?=$value["id"]?>"><i class="fa fa-edit"></i></a>
										<a data-original-title="修改密码" rel="tooltip" class="btn btn-xs btn-danger" href="<?=$this->url('card/changepwd')?>?id=<?=$value["id"]?>"><i class="fa fa-unlock-alt"></i></a>
										<?}?>
									</td>
								</tr>
								<?}?>
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
