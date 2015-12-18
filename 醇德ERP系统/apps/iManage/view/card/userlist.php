<section class="content-header">
    <h1>
        会员管理
        <small>会员列表</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
        <li><a href="#">会员卡管理</a></li>
        <li class="active">会员管理</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">会员列表</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-init">
                            <thead>
                                <tr>
                                    <th style="display:none;">排序</th>
                                    <th>会员姓名</th>
                                    <th>会员性别</th>
                                    <th>充值总额</th>
                                    <th>消费总额</th>
                                    <th>余额</th>
                                    <th>状态</th>
                                    <th>最后一次消费时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?foreach($re as $key=>$val){?>
                                <tr>
                                    <td style="display:none;"><?=-$val['created']?></td>
                                    <td><?=$val['truename']?></td>
                                    <td><?=$val['sex']?>&nbsp;&nbsp;</td>
                                    <td>￥<?=$val['allmoney']?></td>
                                    <td>￥<?echo $val['allmoney']-$val['nowmoney'];?></td>
                                    <td>￥<?=$val['nowmoney']?></td>
                                    <td>
                                        <?if($val['status']==1){?>
                                        <span class='label label-success'>正常</span>
                                        <?}else if($val['status']==-1){?>
                                        <span class='label label-danger'>已挂失</span>
                                        <?}else{?>
                                        <span class='label label-warning'>冻结</span>
                                        <?}?>
                                    </td>
                                    <td><?=empty($val['lastpaytime'])?'':date("Y-m-d H:i:s",$val['lastpaytime'])?></td>
                                    <td>
                                        <a data-original-title="详情" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('card/userinfo',array('id'=>$val['id']))?>"><i class="fa fa-edit"></i></a>
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