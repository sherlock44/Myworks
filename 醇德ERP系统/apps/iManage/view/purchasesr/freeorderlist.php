<section class="content-header">
    <h1>
        订单管理
        <small>赠送关联订单</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> ERP系统</a></li>
        <li><a href="#">订单管理</a></li>
        <li class="active">赠送关联订单</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">赠送关联订单</h3>
                    <div class="box-tools pull-right">
                        <a rel="tooltip" data-original-title="添加" href="<?=$this->url("freeorder/apply")?>" class="btn btn-default btn-sm"> <i class="fa fa-plus"></i>添加</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-init">
                            <thead>
                                <tr>
                                    <th style="display:none;">订货日期</th>
                                    <th>订货日期</th>
                                    <th>订单号</th>
                                    <th>加盟商</th>
                                    <th>代理级别</th>
                                    <th>合计(元)</th>
                                    <th>付款日期</th>
                                    <th>发货日期</th>
                                    <th>关联订单</th>
                                    <th>状态</th>
                                    <th>备注</th>
                                    <th >操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?foreach($re as $key=>$val){?>
                                <tr >
                                    <td style="display:none;"><?=0-$val['created']?></td>
                                    <td><?=date("Y-m-d",$val['created'])?></td>
                                    <td><?=$val['ordernum']?></td>
                                    <td><?=$val['shoppname']?></td>
                                    <td><?=isset($supply[$val['supplytypeid']])?$supply[$val['supplytypeid']]:''?></td>
                                    <td><?=$val['price']?></td>
                                    <td><?if(!empty($val['paydate'])){echo date("Y-m-d",$val['paydate']);}?></td>
                                    <td><?if(!empty($val['senddate'])){echo date("Y-m-d",$val['senddate']);}?></td>
                                    <!--td><?if(!empty($val['acceptancedate'])){echo date("Y-m-d",$val['acceptancedate']);}?></td-->
                                    <td><?=$val['freeordernum']?></td>
                                    <td><?=$this->conf['orderstatus'][$val['status']]?><?if($val['orderbackstatus']>0){?><span style="color:red;"><b>【退货】</b></span><?}?></td>
                                    <td><?=$val['remark']?></td>
                                    <td>
                                        <a data-original-title="查看订购商品" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('purchasesr/orderinfo',array('ordernum'=>$val['ordernum'],'token'=>$val['token']))?>"><i class="fa fa-edit"></i></a>
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