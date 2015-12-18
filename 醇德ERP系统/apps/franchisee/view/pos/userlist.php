<section class="content-header">
  <h1>
    会员统计
    <small>本店会员数据统计</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> 采购平台</a></li>
    <li><a href="#">收银统计</a></li>
    <li class="active">会员统计</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">会员列表</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover table-init">
            <thead>
             <tr>
              <th>卡号</th>
              <th>会员姓名</th>
              <th>联系电话</th>
              <th>邮箱</th>
              <th>生日</th>
              <th>开卡时间</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
           <?foreach ($rs as $key=>$val){?>
           <tr>
            <td><?=$val['cardnum']?></td>
            <td><?=$val['truename']?$val['truename']:"暂未设置";?></td>
            <td><?=$val['mobile']?$val['mobile']:"暂未设置";?></td>
            <td><?=$val['email']?$val['email']:"暂未设置" ;?></td>
            <td><?=date('Y-m-d',$val['birthdaytime'])?></td>
            <td><?=date('Y-m-d',$val['opentime'])?></td>
            <td>
             <a data-original-title="消费记录" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('pos/recharge',array('card'=>$val['cardnum']))?>"  ><i class="fa fa-edit"></i></a>
             <a data-original-title="关联订单" rel="tooltip" class="btn btn-xs btn-info" href="<?=$this->url('pos/consume',array('card'=>$val['cardnum']))?>" ><i class="fa fa-share-alt"></i></a>	
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