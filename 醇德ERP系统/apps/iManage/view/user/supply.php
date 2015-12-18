<section class="content-header">
    <h1>
        供应商管理
        <small>供应商列表</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
        <li><a href="#">客户管理</a></li>
        <li class="active">供应商列表</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">供应商列表</h3>
                    <div class="box-tools pull-right">
                        <a href="<?=$this->url('user/addsupply')?>" class="btn btn-default btn-sm">
                            <i class="fa fa-user-plus"></i>
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
                                    <th>名称</th>
                                    <th>供应商类型</th>
                                    <th>简介</th>
                                    <th>联系人</th>
                                    <th>电话</th>
                                    <th>地址</th>
                                    <th>状态</th>
                                    <th>添加时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?foreach($re as $key=>$val){?>
                                <tr>
                                    <td><?=$val['title']?></td>
                                    <td><?=$val['typename']?></td>
                                    <td><?=$val['remark']?></td>
                                    <td><?=$val['name']?></td>
                                    <td><?=$val['mobile']?></td>
                                    <td><?=$val['address']?></td>
                                    <td><?if($val['status']==0){echo '<span class="label label-warning">禁用</span>';}else{echo '<span class="label label-success">正常</span>';}?></td>
                                    <td><?=date("Y-m-d",$val['created'])?></td>
                                    <td>
                                        <a data-original-title="修改" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('user/editsupply',array('id'=>$val['id']))?>"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("user/delsupply")?>?id=<?=$val["id"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-trash"></i></a>
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