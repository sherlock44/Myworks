<section class="content-header">
  <h1>
    账号管理
    <small>账号信息管理</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
    <li><a href="#">系统管理</a></li>
    <li class="active">账号管理</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">账号列表</h3>
          <div class="box-tools pull-right">
            <a href="<?=$this->url('system/add')?>" class="btn btn-default btn-sm"> <i class="fa fa-user-plus"></i>
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
                  <th>账户</th>
                  <th>所属权限组</th>
                  <th>姓名</th>
                  <th>联系方式</th>
                  <th>邮箱</th>
                  <th>账号状态</th>
                  <th>创建时间</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                <? foreach($re as $key=>$val){ ?>
                <tr>
                  <td><?=$val['id']?></td>
                  <td><?=$val['name']?></td>
                  <td><?=$val['title']?></td>
                  <td><?=$val['truename']?></td>
                  <td><?=$val['mobile']?$val['mobile']:'未设置' ;?></td>
                  <td><?=$val['email']?$val['email']:'未设置';?></td>
                  <td><?if($val['status']==0){echo '<span class="label label-warning">冻结</span>';}else{echo '<span class="label label-success">正常</span>';}?></td>
                  <td><?=date('Y-m-d',$val['created'])?></td>
                  <td>
                    <a data-original-title="修改" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('system/edit',array('id'=>$val['id'],'groupid'=>$val['groupid']))?>"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>
                <?} ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>