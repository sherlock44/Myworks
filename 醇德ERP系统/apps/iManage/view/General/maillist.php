<section class="content-header">
<h1>
  邮件推送
  <small>邮件推送管理</small>
</h1>
<ol class="breadcrumb">
  <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
  <li><a href="#">通用管理</a></li>
  <li class="active">邮件推送</li>
</ol>
</section>
<section class="content">
	<div class="row">
  <div class="col-xs-12">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">已发送邮件信息</h3>
				 <div class="box-tools pull-right">
				    <a href="<?=$this->url('General/sendmail?sdtype=2')?>" class="btn btn-default btn-sm"><i class="fa fa-send"></i>
              写邮件给加盟商
            </a>
						 <a href="<?=$this->url('General/sendmail?sdtype=1')?>" class="btn btn-default btn-sm"><i class="fa fa-users"></i>
              写邮件给内部员工
            </a>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
		      <table class="table table-bordered table-hover table-init">
					   <thead>
      				<tr>
							  <th>ID</th>
                <th>主题</th>
                <th>发送人</th>
                <th>用户类型</th>
                <th>发送时间</th>
                <th>发送人数</th>
                <th>操作</th>
						</tr>
    				</thead>
    				<tbody>
					   <?
                    foreach($rs as $key=>$val){
                        ?>
                        <tr>
                            <td><?=$val['id']?></td>
                            <td><?=$val['title']?></td>
                            <td>
                            <?
                              switch ($val['type']) {
                                  case 1:
                                      echo $val['scnm']?$val['scnm']:'未设置';
                                      break;
                                  case 2:
                                      echo $val['glynm']?$val['glynm']:'未设置';
                                      break;
                                  case 3:
                                      echo $val['jmsnm']?$val['jmsnm']:'未设置';
                                      break;
                                  default:
                                      echo '未知';
                                      break;
                              }
                            ?>
                            </td>
                             <td>
                            <?
                              switch ($val['type']) {
                                  case 1:
                                      echo '商城用户';
                                      break;
                                  case 2:
                                      echo '内部员工';
                                      break;
                                  case 3:
                                      echo '加盟商';
                                      break;
                                  default:
                                      echo '未知';
                                      break;
                              }
                            ?>
                            </td>
                            <td><? echo date("Y-m-d h:i:s",$val['time'])?></td>
                           <td><?=$val['emailnum']?></td>
                            <td>
                               <a data-original-title="查看" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('General/emaskin',array('id'=>$val['id']))?>"  ><i class="fa fa-edit"></i></a>
                               <a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("General/delema")?>?id=<?=$val["id"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-trash"></i></a> 
                            </td>
                        </tr>
                        <?
                    }
                ?>
            </tbody>
					</table>
				</div>
			</div>
    </div>
		</div>
	</div>
</section>