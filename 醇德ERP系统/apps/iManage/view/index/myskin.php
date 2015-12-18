<section class="content-header">
	<h1>
		系统管理
		<small>站内信息详情</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="<?=$this->url('system/admin')?>">系统管理</a></li>
		<li class="active">站内信息详情</li>
	</ol>
</section>
<section class="content">
	<form  class='box box-primary form-validate' action='<?=$this->url("system/add")?>'  id="login" name="login" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">站内信息详情</h3>
			<div class="box-tools pull-right">
				<button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
			</div>
		</div><!-- /.box-header -->
		<div class="box-body">
			<div class="row">
				<!-- left column -->
				<div class="col-md-6">
					<!-- general form elements -->
					<div class="form-group">
						<label for="uname">标题</label>
						<?=$re['title']?>
					</div>
					<div class="form-group">
						<label for="address">内容</label>
						  <?=$re['content']?>
					</div>
					<div class="form-group">
						<label for="truename">发送时间</label>
						 <? echo date("Y-m-d h:i:s",$re['time'])?>
					</div>
					
				</div>
			</div>
		</div>
		<div class="box-footer">
			
			<button class="btn btn-default" type="button" onclick="returnList()"><i class="fa fa-reply"></i> 返回</button>
		</div>
	</form>
</section>

<script>
//返回列表
   function returnList(){
        window.location.href='<?=$this->url("index/mywebInfo")?>';
    }

   
</script>