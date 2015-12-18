<!-- daterange picker -->
<!-- <link rel="stylesheet" href="/public/adminlte/plugins/daterangepicker/daterangepicker-bs3.css"> -->
<section class="content-header">
<h1>
  收银统计
  <small>本店收银数据统计</small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> 采购平台</a></li>
  <li><a href="#">收银统计</a></li>
  <li class="active">收银统计</li>
</ol>
</section>
<section class="content">
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">收银统计列表</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                 </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <form action="<?=$this->url("pos/cashier")?>" method="GET" style="float:left;" class="input-group input-group-sm">
                    <select style="width: 150px;" name="date"  class="form-control" >
                       <option value='' <?=isset($_GET['date'])&&$_GET['date']==''?"selected":""?> >所有</option>
                       <option value='1' <?=isset($_GET['date'])&&$_GET['date']=='1'?"selected":""?> >今天</option>
                       <option value='2' <?=isset($_GET['date'])&&$_GET['date']=='2'?"selected":""?> >昨天</option>
                       <option value='3' <?=isset($_GET['date'])&&$_GET['date']=='3'?"selected":""?> >本周</option>
                       <option value='4' <?=isset($_GET['date'])&&$_GET['date']=='4'?"selected":""?> >本月</option>
                    </select>
                    <button style="margin-left: 10px;" class="btn btn-sm btn-primary" type="submit">筛选</button>
                </form>
                <table id="DataTables_Table_0_length" class="table table-bordered table-hover">
                  <thead>
        						<tr>
        							<th style="display:none;">序号</th>
        							<th>工作人员</th>
        							<th>联系方式</th>
        							<th>订单总数</th>
        							<th>总销售额</th>
        							<th>现金支付额</th>
        							<th>卡付额</th>
        							<th>在线支付额</th>
        							<th>登录时间</th>
        							<th>结束时间</th>
        						</tr>
        						</thead>
        						<tbody id="nList">
        						  <?foreach ($re as $k=>$v){?>
        	                        <tr>
        								<td style="display:none;"><?echo (0-$v['id']);?></td>
        								<td><?=$v['workername']?></td>
        								<td><?=$v['mobile']?></td>
                        <td><?=$v['ordernum']?></td>
                        <td><?=$v['totalprice']?></td>
                        <td><?=$v['cashpaymoney']?></td>
                        <td><?=$v['cardpaymoney']?></td>
                        <td><?=$v['netpaymoney']?></td>  
                        <td><?=date('Y-m-d H:i:s',$v['logintime'])?></td>
                        <td><?=date('Y-m-d H:i:s',$v['endtime'])?></td>
        							</tr>
        							<?}?>
        						</tbody>
                  </table>
                    <!-- Date and time range -->
            	</div>
        	</div>
    	</div>
    </div>
</section>
<script>
      $(document).ready(function () {
        $('#DataTables_Table_0_length').dataTable({
        	"dom": '<"toolbar">frtip',
            "language": {
                "search":"搜索",
                "searchPlaceholder":"请输入关键字",
                "lengthMenu": "每页 _MENU_ 条记录",
                "zeroRecords": "没有找到记录",
                "info": "第 _PAGE_ 页 - 共 _PAGES_ 页",
                "infoEmpty": "无记录",
                "infoFiltered": "(从 _MAX_ 条记录过滤)",
                "paginate": {
                    "last": "尾页",
                    "last": "尾页",
                    "previous": "上一页",
                    "next": "下一页"
                }
             }
        });
		 //Date range picker
   //      $('#reservation').daterangepicker( { language: 'zh-CN'});
   //      //Date range picker with time picker
   //      $('#reservationtime').daterangepicker({language: 'zh-CN',timePicker: true, timePickerIncrement: 30, format: 'YYYY-MM-DD'});
   //      //Date range as a button
		 // $('#daterange-btn').daterangepicker(
   //          {
   //            ranges: {
   //              'Today': [moment(), moment()],
   //              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
   //              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
   //              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
   //              'This Month': [moment().startOf('month'), moment().endOf('month')],
   //              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
   //            },
   //            startDate: moment().subtract(29, 'days'),
   //            endDate: moment()
   //          },
   //      function (start, end) {
   //        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
   //      }
   //      );
		 // //Timepicker
   //      $(".timepicker").timepicker({
   //        showInputs: false
   //      });
      });
</script>

