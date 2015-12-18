					<div id="main">
			<div class="container-fluid"><div class="page-header">
	<div class="pull-left">
		<h1>商品管理</h1>
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
			<a href="javascript:;">店铺管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">商品管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">商品管理</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
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
				<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
				<div id="DataTables_Table_0_length" class="dataTables_length" style="height:36px;">				
				<form action="<?=$this->url("goods/lists")?>" method="GET"  id="bb">
					<div class="row-fluid"  style="width:1000px;height:5px;">
						
							
                       
						<div class="span2 ">
                            <div class="control-group">                                
                                <div class="controls controls-row">
                                     <select name='categoryuuid' id='categoryuuid' class="input-block-level">					
									 <option value='' <?=isset($_GET['categoryuuid'])&&$_GET['categoryuuid']==''?"selected":""?> >商品分类</option>
									  <?=$trees?>
									 </select>
                                </div>
                            </div>
                       </div>
						<div class="span2 ">
                            <div class="control-group">                                
                                <div class="controls controls-row">
                                     <select name='branduuid' id='branduuid' class="input-block-level">					
									 <option value='' <?=isset($_GET['branduuid'])&&$_GET['branduuid']==''?"selected":""?> >全部品牌</option>
									 <?foreach($brand as $val){?>
										<option value='<?=$val['id']?>' <?=isset($_GET['branduuid'])&&$_GET['branduuid']==$val['id']?"selected":""?> ><?=$val['title']?></option>
									 <?}?>
									 </select>
                                </div>
                            </div>
                       </div>					   
						<div class="span3">
                            <div class="control-group">                                
                                <div class="controls controls-row">
                                     <input  id="userphone" name="userphone" class="input-block-level" type="text" placeholder="商品名称/商品编号" value="<?=$userphone?>">                              	
                                    
                                </div>
                            </div>
                       </div>
                      
                        <div class="span1">                            
                                    <input type="submit" class="btn btn-primary" value="搜索">                             
                       </div>                       
				</div>
					
					
                   </form>
				   </div>
				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
					<thead>
						<tr>
							<th width="10%">商品编号</th>
							<th width="10%">商品名称<br/>拼音码</th>
							
							<th width="10%">商品图片</th>
							<th width="10%">商品分类</th>
							<th width="10%">成本价<br/>销售价<br/>折扣价</th>
							<th width="10%">供应商</th>							
							<th width="10%">库存</th>							
					
						</tr>
					</thead>
					<tbody>
						<?foreach ($re as $value) {?>
						<tr>
							<td><?=$value['barcode']?></td>
							<td><?=$value['title']?><br/><?=$value['pingincode']?></td>
							
							
							<td>
							<?if($value["imgpath"]){?>
								<img width=50 height=50   src="<?=$value["imgpath"]?>">
							  <?}else{?>
							    <img  width=50 height=50  src="/public/assets/sysadmin/img/200_200_no_image.gif">
							    <?}?></td>
							<td><?=$value['fctitle']?></td>
							<td><?=$value['costprice']?><br/><?=$value['price']?><br/><?=$value['discountprice']?></td>	
							<td><?=$value['supplier']?></td>
							<td><?=$value['num']?></td>
										
						
						
							
						</tr>
					<?}?>	
					</tbody>
				</table>
				<?=$pageHtml?>
			</div>
			</div>
		</div>
	</div>
</div>
</div></div>