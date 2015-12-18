<section class="content-header">
    <h1>
        退货管理
        <small>库房核验订单列表</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> 后台管理</a></li>
        <li><a href="#">退货管理</a></li>
        <li class="active">库房核验订单列表</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">库房核验订单列表</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-init">
                            <thead>
                                <tr>
                                    <th style="display:none;">退货日期</th>
                                    <th>退货日期</th>
                                    <th>退货单号</th>
                                    <th>关联单号</th>
                                    <th>订单金额(元)</th>
                                    <th>状态</th>
                                    <th>备注</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?foreach($re as $key=>$val){?>
                                <tr>
                                    <td style="display:none;"><?=-$val['orderbackcreated']?></td>
                                    <td><?=date("Y-m-d",$val['orderbackcreated'])?></td>
                                    <td><?=$val['backordernum']?></td>
                                    <td><?=$val['ordernum']?></td>
                                    <td><?=$val['price']?></td>
                                    <td><?=$this->conf['orderbackstatus'][$val['backstatus']]?></td>
                                    <td><?=$val['orderbackremark']?></td>
                                    <td>
                                        <a data-original-title="查看退货单" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('orderback/orderinfohouse',array('ordernum'=>$val['ordernum'],'token'=>$val['token']))?>"><i class="fa fa-edit"></i></a>
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