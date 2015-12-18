<section class="content-header">
	<h1>
		库房设置
		<small><?=$house['title']?>库位设置</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">参数设置</a></li>
		<li class="active">库房设置</li>
	</ol>
</section>

<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-th-list"></i>
					<?=$house['title']?>-库位设置
				</h3>

			</div>

			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("preferences/updatehousepos")?>'  id="logins" name="logins" method='post'>
					<?foreach($posarray as  $k=>$val){?>
					<table class="table table-hover table-nomargin  table-bordered" width="100%">
						<thead><tr><th colspan="<?=$house['cols']?>"><?=$k+1?>楼</th></tr></thead>
						<tbody id="table_plan">	
							<?foreach($val as $ke=>$v){?>
							<tr>
								<?foreach($v as $ve){?>
								<td style="padding:0px;">
									<!--input type="text" name="title[]" value="<?=$ve['title']?>" class="span8 cashinput" style="width:100%;margin-bottom:-1px;margin-top:3px;"  -->

									<?=$ve['title']?>
									<br/>
									<input type="hidden" name="id[]"  value="<?=$ve['id']?>" >
								</td>
								<?}?>

							</tr>
							<?}?>

						</tbody>
					</table>
					<?}?>
				</form>
			</div>

			<div class="box-content nopadding">
				<table class="table table-hover table-nomargin  table-bordered" width="100%">
					<tr><td colspan="9" style="text-align:center;"> 
					<button class="btn btn-success" onclick="formcarttj()" >保存方案</button></td></td>
					</table>
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