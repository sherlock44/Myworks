<?php ob_start(); ?>
<section class="content-header">
<h1>
  相关文档
  <small>共享文件管理</small>
</h1>
<ol class="breadcrumb">
  <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
  <li><a href="#">通用模块</a></li>
  <li class="active">相关文档</li>
</ol>
</section>
<section class="content">
	<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">文件管理
					<?foreach($this->filemenu as $k=>$val){?>
					<a class="" style="color:white;" href="<?=$this->url('General/filemanage',array('id'=>$val['id']))?>"  rel="tooltip"><?=$val['title']?></a>
					<?}?>
				</h3>
				<div class="box-tools pull-right">
                	<a href="<?=$this->url('General/Fileupload',array('cateid'=>$cateid))?>" class="btn btn-default btn-sm"> <i class="fa fa-plus"></i>
						添加文件
					</a>
					<a href="<?=$this->url('General/addfilecategory',array('cateid'=>$cateid))?>" class="btn btn-default btn-sm"> <i class="fa fa-folder"></i>
						添加目录
					</a>
              	</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
				<?if($category){?>
				    <table  class="table table-bordered table-hover">
				    	<thead>
					    	<tr>
					    		<th width="50">类型</th>
					    		<th>名称</th>
					    		<th width="100">操作</th>
					    	</tr>
				    	</thead>
				    	<tbody>
					  <?foreach($category as $key=>$val){?>
                        <tr>
                        	<td style="font-size: 16px;">
								<i class="fa fa-folder"></i>
							</td>
							<td  onclick="javascript:window.location.href='<?=$this->url("General/filemanage",array('id'=>$val['id']))?>'">
								<a class="" style="color:#000000;" href="<?=$this->url('General/filemanage',array('id'=>$val['id']))?>" data-original-title="<?=$val['remark']?>" rel="tooltip"><i class="icon-folder-close-alt" ></i><?=$val['title']?></a>
							</td>
							<td>
								<a rel="tooltip" data-original-title="编辑目录" href="<?=$this->url('General/editcategory',array('id'=>$val['id']))?>" class="btn btn-xs btn-success"><i class="fa fa-sign-out"></i></a>
								<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("General/delcategory",array('id'=>$val['id']))?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
                    <?}?>
				<?}?>
				<?if($re){?>
			    	<?foreach($re as $key=>$val){?>
                        <tr>
                        	<td style="font-size: 16px;">
								<i class="fa fa-file-o"></i>
							</td>
							<td onclick="javascript:window.location.href='<?=$val['document']?>'">
								<a class="" style="color:#000000;"  target="_black" href='<?=$val['document']?>' rel="tooltip"><?=$val['name']?></a>
							</td>
							<td>
								<a href="<?=$val['document']?>" class="btn btn-xs btn-success" rel="tooltip" target="_black" data-original-title="下载"><i class="fa fa-download"></i></a>
								<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("General/delupload",array('id'=>$val['id']))?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
                    <?}?>
                    </tbody>
				</table>
				<?}?>
				</div>
			</div>
		</div>
	</div></div>
</section>