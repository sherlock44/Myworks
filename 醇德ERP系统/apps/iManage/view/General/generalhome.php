<section class="content-header">
<h1>
  物流管理
  <small>物流管理</small>
</h1>
<ol class="breadcrumb">
  <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
  <li><a href="#">通用管理</a></li>
  <li class="active">物流管理</li>
</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">物流信息列表</h3>
				<div class="box-tools pull-right">
                	<a href="<?=$this->url('General/addgeneral')?>" class="btn btn-default btn-sm"> <i class="fa fa-plus"></i>
                       新增
                    </a>
              	</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
				    <table class="table table-bordered table-hover table-init">
					<thead>
        				<tr>
							<th >发货地物流<br>公司名称</th>
							<th >发货地物流<br>公司电话</th>
							<th >发货地物流<br>公司联系人</th>
							<th >到达地物流<br>公司名称</th>
							<th >到达地物流<br>公司电话</th>
							<th >到达地物流<br>公司联系人</th>
							<th >夏季价格<br>(散货:元/箱)</th>
							<th >夏季价格<br>(整货:元/吨)</th>
							<th >冬季价格<br>(散货:元/箱)</th>
							<th >冬季价格<br>(整货:元/吨)</th>
							<th >操作</th>
						</tr>
    				</thead>
    				<tbody>
					 <?foreach ($re as $value) {?>
						<tr>
							<td><?=$value['companystart']?></td>
							<td><?=$value['mobilestart']?></td>
							<td><?=$value['usernamestart']?></td>
							<td><?=$value['companyarrive']?></td>
							<td><?=$value['mobilearrive']?></td>
							<td><?=$value['usernamearrive']?></td>
							<td><?=$value['summersmallprice']?></td>
							<td><?=$value['summerbigprice']?></td>
							<td><?=$value['sinwintersmallprice']?></td>
							<td><?=$value['sinwinterbigprice']?></td>
							<td>
							<a data-original-title="修改" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('General/editgeneral')?>?id=<?=$value["id"]?>"><i class="fa fa-edit"></i></a>
							<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("General/generaldel")?>?id=<?=$value["id"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-trash"></i></a>
							</td>
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