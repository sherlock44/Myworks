<section class="content-header">
    <h1>
        退货管理
        <small>选择退货单</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> 后台管理</a></li>
        <li><a href="#">退货管理</a></li>
        <li class="active">选择退货单</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">可退货订单列表</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-init">
                            <thead>
                                <tr>
                                    <th>订货日期</th>
                                    <th>订单号</th>
                                    <th>加盟商</th>
                                    <th>订单金额(元)</th>
                                    <th>付款日期</th>
                                    <th>发货日期</th>
                                    <th>验收日期</th>
                                    <th>状态</th>
                                    <th>备注</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?foreach($re as $key=>$val){?>
                                <tr title="<?=$val['survey']?>">
                                    <td><?=date("Y-m-d",$val['created'])?></td>
                                    <td><?=$val['ordernum']?></td>
                                    <td><?=$val['shoppname']?></td>
                                    <td><?=$val['price']?></td>
                                    <td><?if(!empty($val['paydate'])){echo date("Y-m-d",$val['paydate']);}?></td>
                                    <td><?if(!empty($val['senddate'])){echo date("Y-m-d",$val['senddate']);}?></td>
                                    <td><?if(!empty($val['acceptancedate'])){echo date("Y-m-d",$val['acceptancedate']);}?></td>
                                    <td><?=$this->conf['orderstatus'][$val['status']]?><?if($val['orderbackstatus']>0){?><span style="color:red;"><b>【退货】</b></span><?}?></td>
                                    <td><?=$val['remark']?></td>
                                    <td>
                                        <?if($val['orderbackstatus']==0){?>
                                        <a data-original-title="制定退货单" rel="tooltip" class="btn btn-xs btn-danger" href="<?=$this->url('orderback/add',array('ordernum'=>$val['ordernum'],'token'=>$val['token']))?>"><i class="fa fa-hand-o-up"></i></a>
                                        <?}else{?>
                                        <a data-original-title="查看退货单" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('orderback/add',array('ordernum'=>$val['ordernum'],'token'=>$val['token']))?>"><i class="fa fa-edit"></i></a>
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