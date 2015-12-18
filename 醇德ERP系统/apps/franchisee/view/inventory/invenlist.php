<section class="content-header">
<h1>
  库存情况
  <small>库存明细</small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> 采购平台</a></li>
  <li><a href="#">收银统计</a></li>
  <li class="active">库存情况</li>
</ol>
</section>
<section class="content">
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">库存明细列表</h3>
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
            							<th>商品分类</th>
            							<th>商品名称</th>
            							<th>品牌</th>
            							<th>商品条码</th>
            							<th>保质期(月)</th>
            							<th>库存</th>
            							<th>库存下限</th>
            							<th>销售价</th>
            							<th>保质期至</th>
            						</tr>
            					</thead>
            					<tbody>
            						<?foreach ($rs as $k=>$value){?>
                                    <tr>
            						<td  ><?=isset($categorys[$value['categoryuuid']])?$categorys[$value['categoryuuid']]:'--'?></td>
            						<td ><?=$value['title']?></td>
            						<td  ><?=isset($brands[$value['branduuid']])?$brands[$value['branduuid']]:'--'?></td>
            						<td  ><?=$value['barcode']?></td>
            						<td  ><?=!empty($value['shelflife'])?$value['shelflife']:'--'?></td>
            						<td><?=$value['num']?>瓶</td>
            						<td><?=$value['minnum']?>瓶</td>
            						<td  ><?=$value['price']?>元</td>
            						<td  ><?if(empty($value['shelflife'])){echo '--';}else{echo date("Y-m-d",empty($val['productontime'])?time():$val['productontime']);}?></td>
            						</tr>
            						<?}?>
            				</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>