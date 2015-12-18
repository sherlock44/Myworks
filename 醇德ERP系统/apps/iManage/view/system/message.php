	<div id="main">
			<div class="container-fluid nopadding">
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
			<a href="">消息管理</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="fa fa-close"></i></a>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>
                    发送消息
				</h3>
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate' action='<?=$this->url("system/message")?>'  id="login" name="login" method='post'>
					<div class="control-group">
						<label class="control-label">接收方</label>
						<div class="controls">
							<select name="data[name]" class="input-xlarge">
                                <option value="商户">商户</option>
                                <option value="用户">用户</option>
                            </select>
						</div>
					</div>
					<div class="control-group">
						<label  class="control-label">消息内容</label>
						<div class="controls">
							<textarea name="data[message]" class="input-xlarge" data-rule-required="true" data-rule-minlength="10"></textarea>
						</div>
					</div>
					<div class="form-actions" style="margin: -10px -20px;">
						<input type="submit" class="btn btn-primary" value="确认发送">
					</div>
				</form>
			</div>
		</div>
        <div class="box box-color box-bordered">
            <div class="box-title">
				<h3>
					<i class="icon-user"></i>
                    历史消息
				</h3>
			</div>
            <div class="box-content nopadding">
				<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
				    <table width="100%" class="table table-hover table-nomargin dataTable table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
    					<thead>
    						<tr>
    							<th>接收方</th>
    							<th>消息内容</th>
    						</tr>
    					</thead>
    					<tbody>
    						<?foreach ($re as $key=>$val){?>
                            <tr>
    							<td><?=$val['name']?></td>
    							<td><?=$val['message']?></td>
    						</tr>					
    						<?}?>
    				    </tbody>
    				</table>
    			</div>
			</div>
        </div>
	</div>
</div>
</div>
</div>