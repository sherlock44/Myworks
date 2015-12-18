<section class="content-header">
    <h1>
        采购申请
        <small>采购申请</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> ERP系统</a></li>
        <li><a href="#">采购管理</a></li>
        <li class="active">采购申请</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">申请列表</h3>
                    <div class="box-tools pull-right">
                        <a rel="tooltip" data-original-title="添加" href="<?=$this->url('buyer/addapply')?>" class="btn btn-default btn-sm"> <i class="fa fa-plus"></i>
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
                                    <th style="display:none">ID</th>
                                    <th>名称</th>
                                    <th>采购订单号</th>
                                    <th>申请人</th>
                                    <th>审批人</th>
                                    <th>状态</th>
                                    <th>申请时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?foreach($re as $key=>$val){?>
                                <tr>
                                    <td style="display:none"><?=-$val['id']?></td>
                                    <td><?=$val['title']?></td>
                                    <td><?=$val['ordernum']?></td>
                                    <td><?=$val['cgname']?></td>
                                    <td><?=$val['zgname']?></td>
                                    <td><span style="<?if($val['status']>0 && $val['status']<12){?>color:red;<?}?>"><?=$this->sysconf['purchasestatus'][$val['status']]?></td>
                                    <td><?=date("Y-m-d",$val['created'])?></td>
                                    <td>
                                        <a data-original-title="查看" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('buyer/editapply',array('id'=>$val['id']))?>"><i class="fa fa-sign-out"></i></a>
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