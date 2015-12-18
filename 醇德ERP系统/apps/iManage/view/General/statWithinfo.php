<section class="content-header">
  <h1>
    站内信息
    <small>站内信息管理</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
    <li><a href="#">通用管理</a></li>
    <li class="active">站内信息</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
      <div class="box-header with-border">
          <h3 class="box-title">站内信息</h3>
          <div class="box-tools pull-right">
            <a href="<?=$this->url('General/sendWithinfo')?>" class="btn btn-default btn-sm"> <i class="fa fa-send"></i>&nbsp;&nbsp;写信
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
                  <th>发送用户名</th>
                  <th>主题</th>
                  <th>内容</th>
                  <th>未读/总人数</th>
                  <th>发送时间</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                <?foreach($rs as $key=>$val){?>
                <tr>
                  <td><?=$val['id']?></td>
                  <td><?=$val['name']?></td>
                  <td><?=$val['title']?></td>
                  <td><?=$val['content']?></td>
                  <td><?=$val['noreadnum']?>/<?=$val['readnum']?></td>
                  <td><? echo date("Y-m-d h:i:s",$val['time'])?></td>
                  <td>
                    <a data-original-title="查看" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('General/skin',array('id'=>$val['id']))?>"  ><i class="fa fa-edit"></i></a>
                    <a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("General/delinfo")?>?id=<?=$val["id"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-trash"></i></a> 
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