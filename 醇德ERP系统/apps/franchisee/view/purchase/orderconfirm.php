
<section class="content-header">
    <h1>
      未完成订单
      <small>订单列表</small>
  </h1>
  <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> 采购平台</a></li>
      <li><a href="#">采购管理</a></li>
      <li class="active">未完成订单</li>
  </ol>
</section>
<section class="content">
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">订单列表</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-init">
                        <thead>
                            <tr>
                                <th>订货日期</th>
                                <th>订单号</th>
                                <th>订单金额</th>
                                <th>付款日期</th>
                                <th>发货日期</th>
                                <th>验收日期</th>
                                <th>订单状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?foreach($re as $key=>$val){?>
                            <tr >
                                <td><?=date("Y-m-d H:m:s",$val['created'])?></td>
                                <td><?=$val['ordernum']?></td>
                                <td>
                                    <?if($val['orderbackstatus']>0 && $val['backstatus']==5){?>
                                    ¥ <?=$val['price']-$val['backmoney']?>
                                    <?}else{?>
                                    ¥ <?=$val['price']?>
                                    <?}?>
                                </td>
                                <td><?if(!empty($val['paydate'])){echo date("Y-m-d",$val['paydate']);}?></td>
                                <td><?if(!empty($val['senddate'])){echo date("Y-m-d",$val['senddate']);}?></td>
                                <td><?if(!empty($val['acceptancedate'])){echo date("Y-m-d",$val['acceptancedate']);}?></td>
                                <td><?=$this->conf['orderstatus'][$val['status']]?><?if($val['orderbackstatus']>0 && $val['backstatus']!=5){?>
                                    <span style="color:red;"><b>【退货中】</b></span>
                                    <?}else if($val['orderbackstatus']>0 && $val['backstatus']==5){?>
                                    <span style="color:red;"><b>【退货已完成】</b></span>
                                    <?}?>
                                </td>
                                <td>
                                   <a class="btn btn-xs btn-success" href="<?=$this->url('purchase/orderinfo',array('ordernum'=>$val['ordernum']))?>"><i class="fa fa-edit"></i></a>
                                   <?if($val['status']==0){?>
                                   <a href="javascript:pub_alert_confirm(this,'确定要取消吗？','<?=$this->url("purchase/updatestatus")?>?id=<?=$val["id"]?>&status=-1');" class="btn btn-xs btn-danger" title="取消"><i class="fa fa-trash"></i></a>
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
</section>