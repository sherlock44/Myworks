<section class="content-header">
    <h1>
        系统日志
        <small>系统账号操作日志</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
        <li><a href="#">系统管理</a></li>
        <li class="active">系统日志</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">日志列表</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-init">
                            <thead>
                                <tr>
                                    <th style="display:none;">ID</th>
                                    <th>ID</th>
                                    <th>操作用户</th>
                                    <th>标题</th>
                                    <th>内容</th>
                                    <th>时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?foreach($re as $key=>$val){?>
                                <tr>
                                    <td  style="display:none;"><?=-$val['id']?></td>
                                    <td><?=$val['id']?></td>
                                    <td><?=$val['name']?></td>
                                    <td><?=$val['title']?></td>
                                    <td><?=$val['content']?></td>
                                    <td><? echo date("Y-m-d h:i:s",$val['created'])?></td>
                                    <td>
                                        <a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("log/delelog")?>?id=<?=$val["id"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-trash"></i></a> 
                                    </td>
                                </tr>
                                <?}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>