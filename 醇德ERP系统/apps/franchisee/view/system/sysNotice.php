<section class="content-header">
<h1>
  系统消息
  <small>系统站内信</small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> 采购平台</a></li>
  <li><a href="#">管理中心</a></li>
  <li class="active">系统消息</li>
</ol>
</section>
<section class="content">
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">系统消息列表</h3>
            </div>
			<div class="box-body">
                <div class="table-responsive">
    				<table class="table table-bordered table-hover table-init">
    					<thead>
    						<tr>
    							<th>ID</th>
    							<th>发送者</th>
                                <th>信息状态</th>
    							<th>发送时间</th>
                                <th>操作</th>
    						</tr>
    					</thead>
                        <?
                            foreach($re as $key=>$val){
                                ?>
                                <tr>
                                    <td><?=$val['id']?></td>
                                    <td><?=$val['truename']?></td>
                                    <td><?=$val['sign']==1?'未读':'已读';?></td>
                                    <td><? echo date("Y-m-d h:i:s",$val['time'])?></td>
                                    <td>
                                       <a data-original-title="查看" rel="tooltip" class="btn btn-small btn-success" href="<?=$this->url('system/myskin',array('id'=>$val['id']))?>"  ><i class="icon-edit"></i></a>
                                       <a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("system/delinfo")?>?id=<?=$val["id"]?>');" class="btn btn-small btn-danger" title="删除"><i class="icon-remove"></i></a> 
                                    </td>
                                </tr>
                                <?
                            }
                        ?>
    				</table>
                </div>
			</div>
		</div>
	</div>
</section>
