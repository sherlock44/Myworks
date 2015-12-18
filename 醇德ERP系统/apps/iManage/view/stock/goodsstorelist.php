<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<section class="content-header">
	<h1>
		当前库存管理
		<small><?=$re['title']?> 库位设置</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">库存管理</a></li>
		<li class="active">当前库存管理</li>
	</ol>
</section>
<section class="content">
	<form  class='box box-primary form-validate' action='<?=$this->url("stock/addgoodsstore")?>'  id="login" name="login" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">库位列表</h3>
			<div class="box-tools pull-right">
				<button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
			</div>
		</div><!-- /.box-header -->
		<div class="box-body">
			<?foreach($posarray as  $k=>$val){?>
			<table class="table table-hover table-nomargin  table-bordered">
				<thead><tr><th colspan="<?=$house['cols']?>"><?=$k+1?>楼</th></tr></thead>
				<tbody id="table_plan">	
					<?foreach($val as $ke=>$v){?>
					<tr>
						<?foreach($v as $ve){?>
						<td style="padding:0px;text-align:center;">
							<label for="label_<?=$ve['id']?>"><input type="checkbox" id="label_<?=$ve['id']?>" name="posid[]" value="<?=$ve['id']?>"  <?if(in_array($ve['id'],$goodspos)){echo "checked";}?>  >&nbsp;<?=$ve['myrows']?>行<?=$ve['colspan']?>列</label>
							<input type="hidden" name="id[]"  value="<?=$ve['id']?>" >
						</td>
						<?}?>

					</tr>
					<?}?>

				</tbody>
			</table>
			<?}?>
		</div>
		<div class="box-footer">
			<input type="hidden" name="goodsid" value="<?=$re['id']?>">
			<input type="hidden" name="houseid" value="<?=$house['id']?>">
			<button class="btn btn-success" type="submit">保存</button>
		</div>
	</form>
</section>	
