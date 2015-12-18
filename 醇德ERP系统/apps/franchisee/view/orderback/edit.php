<div id="main">
    <div class="container-fluid">
        <div class="page-header">
        	<div class="pull-left">
        		<h1>采购管理</h1>
        	</div>
        	<div class="pull-right">
        		<ul class="stats">
        			<li class='lightred'>
        				<i class="icon-calendar"></i>
        				<div class="details">
        					<span class="big"></span>
        					<span></span>
        				</div>
        			</li>
        		</ul>
        	</div>
        </div>
<script type="text/javascript">
function currentTime(){
	var $el = $(".stats .icon-calendar").parent(),
	currentDate = new Date(),
	monthNames = [1,2,3,4,5,6,7,8,9,10,11,12],
	dayNames = ["周日","周一","周二","周三","周四","周五","周六"];

	$el.find(".details span").html(currentDate.getFullYear() + " - " + monthNames[currentDate.getMonth()] + " - " + currentDate.getDate());
	$el.find(".details .big").last().html(currentDate.getHours()+":"+ ("0" + currentDate.getMinutes()).slice(-2) + ", " + dayNames[currentDate.getDay()]);
	setTimeout(function(){
		currentTime();
	}, 10000);
}
currentTime();
</script>
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="javascript:;">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">编辑退货单</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/chosen/chosen.css">
<script src="/public/assets/sysadmin/js/plugins/chosen/chosen.jquery.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/jquery.dataTables.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/TableTools.css">
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/TableTools.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColReorder.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColVis.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.columnFilter.js"></script>
        <div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					商品列表
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
					<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("orderback/updatebackgoods")?>'  id="logins" name="logins" method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        						<tr>
        							<th>选择</th>
        							<th>名称</th>
        							<th>图片</th>
        							<th>价格</th>
                                    <th>订单数量</th>
                                    <th>退货数量</th>
        						</tr>
        					</thead>
                            <?
                                foreach($goods as $key=>$value){
                                    ?>
                                    <tr>
            						
            							<td>
										<input type="checkbox" name="ofid[]" value="<?=$value['ofid']?>">
										<input type="hidden" name="goodsid_<?=$value['ofid']?>" value="<?=$value['id']?>">
										<input type="hidden" name="price_<?=$value['ofid']?>" value="<?=$value['price']?>">
										<input type="hidden" name="buynum_<?=$value['ofid']?>" value="<?=$value['num']?>">
										
										</td>
            								<td><?=$value['title']?></td>
            								<td><img width=50 height=50   src="<?=$value["imgpath"]?>"></td>
            							<td><?=$value['price']?></td>
            							<td><?=$value['num']?></td>
            							
            							<td>
											<input type="text" id="goodsnum_<?=$value['ofid']?>" name="goodsnum_<?=$value['ofid']?>"   value="" class="span8" data-rule-required="false" data-rule-number="false" data-rule-minlength="1" placeholder="只能填数字">
						                </td>
            						</tr>
                                    <?
                                }
                            ?>
        				</table>
						<input type="hidden" value="<?=$id?>" name="id">
						 </form>
						<div class="dataTables_info" id="DataTables_Table_0_info">
						
						<button class="btn btn-success" onclick="formcarttj()" >&nbsp;&nbsp;确认退货</button>
						</div>
        			</div>
        		</div>
        	</div>
        </div>
    </div>
</div>
<script>
	function formcarttj(){
		$("#logins").submit();
	
	}

</script>