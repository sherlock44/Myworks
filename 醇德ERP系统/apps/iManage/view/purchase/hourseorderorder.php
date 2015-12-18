<section class="content-header">
    <h1>
        已完成订单
        <small>已完成订单管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
        <li><a href="#">订单管理</a></li>
        <li class="active">已完成订单</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">已完成订单列表</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-init">
                            <thead>
                                <tr>
                                    <th style="display:none;">订货日期</th>
                                    <th >订货日期</th>
                                    <th >订单号</th>
                                    <!--th>订单金额(元)</th>
                                    <th >付款日期</th-->
                                    <th >发货日期</th>
                                    <th >验收日期</th>
                                    <th>状态</th>
                                    <th>备注</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?foreach($re as $key=>$val){?>
                                <tr >
                                    <td style="display:none;"><?=0-$val['created']?></td>
                                    <td><?=date("Y-m-d",$val['created'])?></td>
                                    <td><?=$val['ordernum']?><?if($val['orderbackstatus']>0){?>&nbsp;&nbsp;<span style="color:red;">[已退货]</span><?}?></td>
                                    <!--td>¥ <?=$val['price']?></td>
                                    <td><?if(!empty($val['paydate'])){echo date("Y-m-d",$val['paydate']);}?></td-->
                                    <td><?if(!empty($val['senddate'])){echo date("Y-m-d",$val['senddate']);}?></td>
                                    <td><?if(!empty($val['acceptancedate'])){echo date("Y-m-d",$val['acceptancedate']);}?></td>
                                    <td><?=$this->conf['orderstatus'][$val['status']]?></td>
                                    <td><?=$val['remark']?></td>
                                    <td>
                                        <a data-original-title="查看订购商品" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('purchase/orderinfohouse',array('ordernum'=>$val['ordernum'],'token'=>$val['token']))?>"><i class="fa fa-edit"></i></a>
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