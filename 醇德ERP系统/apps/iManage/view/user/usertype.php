<section class="content-header">
  <h1>
    客户类型
    <small>客户类型管理</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
    <li><a href="#">参数设置</a></li>
    <li class="active">客户类型</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">客户列表</h3>
          <div class="box-tools pull-right">
            <a href="<?=$this->url('user/addusertype')?>" class="btn btn-default btn-sm">
              <i class="fa fa-plus"></i>
              添加
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
                  <th>名称</th>
                  <th>说明</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                <?foreach($re as $key=>$val){?>
                <tr>
                  <td><?=$val['id']?></td>
                  <td><?=$val['title']?></td>
                  <td><?=$val['remark']?$val['remark']:'暂无说明';?></td>
                  <td>
                    <a class="btn btn-xs btn-success" href="<?=$this->url('user/editusertype',array('id'=>$val['id']))?>">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("user/delusertype")?>?id=<?=$val["id"]?>');" class="btn btn-xs btn-danger">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
                <?  } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>