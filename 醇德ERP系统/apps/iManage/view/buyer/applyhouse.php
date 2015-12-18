<section class="content-header">
    <h1>
        采购计划
        <small>采购计划</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> ERP系统</a></li>
        <li><a href="#">采购管理</a></li>
        <li class="active">采购计划</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">采购列表</h3>
                    <div class="box-tools pull-right">
                        <a href="<?=$this->url('buyer/addapply')?>" class="btn btn-default btn-sm"> <i class="fa fa-plus"></i>
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
                                    <th>申请时间</th>
                                    <th>采购订单号</th>
                                    <th>名称</th>
                                    <th>申请人</th>
                                    <th>审批人</th>
                                    <th>数量</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?foreach($re as $key=>$val){?>
                                <tr>
                                    <td style="display:none"><?=-$val['id']?></td>
                                    <td><?=date("Y-m-d H:i:s",$val['created'])?></td>
                                    <td><?=$val['ordernum']?></td>
                                    <td><?=$val['title']?></td>
                                    <td><?=$val['cgname']?></td>
                                    <td><?=$val['zgname']?></td>
                                    <td><?=$val['allgoodsnum']?></td>
                                    <td style="<?if($val['status']>0 && $val['status']<12){?>color:red;<?}?>"><?=$this->sysconf['purchasestatus'][$val['status']]?></td>
                                    <td>
                                        <a data-original-title="查看" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('buyer/storeinfo',array('id'=>$val['id']))?>"><i class="fa fa-edit"></i></a>
                                        <?if($val['status']==0 && $val['memberid']==$this->info['id']){?>
                                        <a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("buyer/delapply")?>?id=<?=$val["id"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-trash"></i></a>
                                        <?}?>
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