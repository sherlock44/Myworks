<div id="main">
    <div class="container-fluid">
        <div class="page-header">
        	<div class="pull-left">
        		<h1>会员卡管理</h1>
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
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">系统管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">会员卡管理</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="fa fa-close"></i></a>
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
        					会员卡管理
        				</h3>
        			</div>
        			<div class="box-content nopadding">
        				<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
                    
                    <div id="DataTables_Table_0_length" class="dataTables_length" style="height:36px;" >                
                        <form action="<?=$this->url("card/cardinfo")?>" method="GET"  id="bb">
                        <div class="row-fluid" style="width:1000px;height:3px;">
                            
                            <div class="span3">
                                <div class="control-group">                                
                                    <div class="controls controls-row">
                                         <select name='cardname' id='cardname' class="input-block-level">                 
                                             <option value='' <?=isset($_GET['cardname'])&&$_GET['cardname']==''?"selected":""?> >所有卡</option>
                                             <option value='1' <?=isset($_GET['cardname'])&&$_GET['cardname']==1?"selected":""?>>已激活卡</option>
                                             <option value='0' <?=isset($_GET['cardname'])&&$_GET['cardname']!==''&&$_GET['cardname']==0?"selected":""?>>未激活</option>
                                         </select>
                                    </div>
                                </div>
                            </div>                      
                            <div class="span3">
                                <div class="control-group">                                
                                    <div class="controls controls-row">
                                         <select name='cardtype' id='cardtype' class="input-block-level">                 
                                             <option value='' <?=isset($_GET['cardtype'])&&$_GET['cardtype']==''?"selected":""?>>所有类型</option>
                                             <?foreach ($rs as $v) {?>
                                                <option value='<?=$v["uuid"]?>' <?=isset($_GET['cardtype'])&&$_GET['cardtype']!==''&&$_GET['cardtype']==$v['uuid']?"selected":""?>><?=$v['title']?></option>
                                             <?}?>
                                         </select>                                    
                                    </div>
                                </div>
                            </div>     
                            <div class="span1">                            
                                        <input type="submit" class="btn btn-primary" value="搜索">                             
                            </div>                       
                        </div>
                        </form>
                    </div>
                    <table width="100%" class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                    <thead>
                        <tr>
                            <th width="15%">ID</th>
                            <th width="15%">会员卡卡号</th>
                            <th width="15%">会员卡类型</th>
                            <th width="15%">会员卡过期时间</th>
                            <th width="10%">会员卡状态</th>
                            <th width="10%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?if ($re!=='') {?>
                            <?foreach ($re as  $value){?>
                            <tr>
                                <td><?=$value['id']?></td>
                                <td><?=$value['cardnum']?></td>
                                <td><?=$value['title']?></td>
                                <td><?=date("Y-m-d",$value['expirationtime'])?></td>
                                <td><?=$value['status']==1?"<span class='label label-success'>激活</span>":"<span class='label label-inverse'>未激活</span>"?></td>
                            <?if ($value['status']==1) {?>
                                <td>
                                    <a data-original-title="查看详情" rel="tooltip" class="btn btn-xs  btn-warning " href="<?=$this->url('card/carddetail')?>?id=<?=$value["id"]?>"><i class="icon-money"></i></a>
                                </td>
                            <?}?>
                            </tr>
                            <?}?>
                        <?}?>
                        <?if ($re == null){?>
                            <tr>
                                <td colspan="5">没有找到相匹配的数据！！</td>
                            </tr>
                        <?}?>
                    </tbody>
                </table>
                <?//=$pageHtml?>
            </div>
        </div>
    </div>
</div>
</div></div>