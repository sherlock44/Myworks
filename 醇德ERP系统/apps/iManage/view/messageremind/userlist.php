<section class="content-header">
    <h1>
        消息提醒设置 
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
        <li><a href="#">参数设置</a></li>
        <li class="active">消息提醒设置</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">已设置的提醒列表</h3>
                    <div class="box-tools pull-right">
                        <a href="<?=$this->url('messageremind/edituser',array('keyword'=>$keyword))?>" class="btn btn-default btn-sm"> <i class="fa fa-check-square-o"></i>
                            选择用户
                        </a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-init">
                            <thead>
                                <tr>
                                    <th >名称</th>
                                    <th >电话</th>
                                    <th >邮箱</th>
                                    <th >状态</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?foreach($re as $val){?>
                                <tr>
                                    <td><?=$val['truename']?></td>
                                    <td><?=$val['mobile']?></td>
                                    <td><?=$val['email']?></td>
                                    <td><?=@$conf[$val['orderstatus']]?></td>
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