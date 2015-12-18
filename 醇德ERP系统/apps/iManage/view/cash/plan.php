<div id="main">
    <div class="container-fluid nopadding">

<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购计划列表</a>
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
        					<?=$apply['title']?> 采购计划列表
        				</h3>
                        <div class="actions">
        					<a rel="tooltip" data-original-title="提交采购计划" href="javascript:void(0);" onclick="tjplan(<?=$applyid?>)" class="btn btn-danger"> 提交采购计划</a>
								<a rel="tooltip" data-original-title="添加" href="<?=$this->url('cash/addplan',array('id'=>$applyid))?>" class="btn btn-danger"><i class="icon-plus"></i> 添加</a>
        				</div>
                    
        			</div>
        			<div class="box-content nopadding">
        				<table class="table table-hover table-nomargin dataTable table-bordered" width="100%">
        					<thead>
        						<tr>
        						
        							<th>ID</th>
        							<th>名称</th>
                                    <th>备注</th>
                                
                                    <th>操作</th>
        						</tr>
        					</thead>
                            <?
                                foreach($plan as $key=>$val){
                                    ?>
                                    <tr>
            						
            							<td><?=$val['id']?></td>
            							<td><?=$val['title']?></td>
            							<td><?=$val['remark']?></td>
            							
            							
            							<td>
     								       <a data-original-title="修改" rel="tooltip" class="btn btn-small btn-success" href="<?=$this->url('cash/editplan',array('id'=>$val['id']))?>"><i class="icon-edit"></i></a>
           								   <a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("cash/delplan")?>?id=<?=$val["id"]?>');" class="btn btn-small btn-danger" title="删除"><i class="icon-remove"></i></a>
						                </td>
            						</tr>
                                    <?
                                }
                            ?>
        				</table>
        			</div>
        		</div>
        	</div>
        </div>
    </div>
</div>
<script>
	function tjplan(applyid){
		$.ajax({
			data:"applyid="+applyid,
			url:"<?=$this->url('cash/changestatus1')?>",
			dataType:"json",
			type:"post",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
					if(r.data == 'back'){
					setTimeout('location.reload()',600);
					}
				  }else{
					pub_alert_error(r.info);
				  }
			
			}
		
		});
	
	}

</script>

