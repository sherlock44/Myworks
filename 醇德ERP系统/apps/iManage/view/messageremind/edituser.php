<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<section class="content-header">
	<h1>
		消息提醒设置
		<small>选择用户列表</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="<?=$this->url('messageremind/messagelist')?>">参数设置</a></li>
		<li class="active">消息提醒设置</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<form  class='box box-primary form-validate' action='<?=$this->url("messageremind/edituser")?>'  id="login" name="login" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">选择用户列表</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<div class="row">
				<!-- left column -->
				<div class="col-md-6">
					<!-- general form elements -->
					<div class="form-group">
						<label for="titlesss">选择消息通知状态</label>
						<select name="orderstatus" onchange="checkorderstatus(this.value);" class="form-control valid">
							<option value="-99" >选择消息通知状态</option>
							<?foreach($conf as $k=>$v){?>
							<option value="<?=$k?>" <?if(isset($_GET['orderstatus']) && $_GET['orderstatus']==$k){echo "selected";}?>><?=$v?></option>
							<?}?>
						</select>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th width="40">
								<input type="checkbox" id="allcheck" onclick="checkall()">
							</th>
							<th>姓名</th>
							<th>联系方式</th>
							<th>邮箱</th>
						</tr>
					</thead>
					<tbody id="tbodyorder">
						<?if(isset($_GET['orderstatus']) && $_GET['orderstatus']!=-99){?>
						<?foreach($re as $key=>$val){?>
						<tr>
							<td><input type="checkbox" value="<?=$val['id']?>" <?if(in_array($val['id'],$hasuserid)){echo "checked";}?> class="userid" name="userid[]"></td>
							<td><?=$val['truename']?></td>
							<td><?=$val['mobile']?$val['mobile']:'未设置' ;?></td>
							<td><?=$val['email']?$val['email']:'未设置';?></td>
						</tr>
						<?}?>
						<?}?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="box-footer">
			<input type='hidden'  name="keyword" value='<?=$keyword?>'>
			<button class="btn btn-success" type="submit"><i class="fa fa-check"></i> 提交</button>
			<button class="btn btn-default" type="button" onclick="returnList()"><i class="fa fa-reply"></i> 返回</button>
		</div>
	</form>
</section>
<!-- /.content -->
<script>
	function checkorderstatus(val){
		if(val==-99){
			$("#tbodyorder").html('');return false;
		}
		window.location.href='/index.php/iManage/messageremind/edituser?keyword=<?=$keyword?>&orderstatus='+val;
	}
	//返回列表
	function returnList(){
		window.location.href='<?=$this->url("messageremind/userlist",array('keyword'=>$keyword))?>';
	}
	function checkall(){
		if($("#allcheck").is(":checked")){

		//$(".goodsid").attr("checked", true);
			$(".userid").each(function(){
				this.checked=true;
			});
		}else{
		// $(".goodsid").removeAttr("checked");
			$(".userid").each(function(){
				this.checked=false;
			});
		}

	}
</script>
