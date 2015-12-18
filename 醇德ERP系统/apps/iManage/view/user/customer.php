<section class="content-header">
    <h1>
        意向客户
        <small>意向客户管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
        <li><a href="#">客户管理</a></li>
        <li class="active">意向客户</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">意向客户列表</h3>
                    <div class="box-tools pull-right">
                        <a href="<?=$this->url('user/addcustomer')?>" class="btn btn-default btn-sm"> <i class="fa fa-plus"></i>
                            添加
                        </a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-init">
                            <thead>
                                <tr>
                                    <th style="display:none;">xxx</th>
                                    <th>ID</th>
                                    <th>来源</th>
                                    <th>公司名称</th>
                                    <th>联系人姓名</th>
                                    <th>联系人电话</th>
                                    <th>意向类型</th>
                                    <th>客户类型</th>
                                    <th>上次回访日期</th>
                                    <th>下次回访日期</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?foreach($re as $key=>$val){?>
                                <tr>
                                    <td style="display:none;"><?=$val['visittime']?></td>
                                    <td><?=$val['id']?></td>
                                    <td><?=$sysconf['clientsource'][$val['source']]?></td>
                                    <td><?=$val['name']?></td>
                                    <td><?=$val['dutyname']?></td>
                                    <td><?=$val['mobile']?></td>
                                    <td><?=$sysconf['intention_type'][$val['intention_type']]?></td>
                                    <td><?=$val['cutitle']?></td>
                                    <td><?if(empty($val['visittime'])||$val['visittime']==0){?>
                                        --
                                        <?}else{?>
                                        <?=date("Y-m-d",$val['visittime'])?>
                                        <?}?>
                                    </td>
                                    <td><?if($val['status']==1){?>回访完成<?}else{?><?=!empty($val['nextvisittime'])?date("Y-m-d",$val['nextvisittime']):"--"?><?}?></td>
                                    <td>
                                        <a class="btn btn-xs btn-success" href="<?=$this->url('user/editcustomer',array('id'=>$val['id']))?>"><i class="fa fa-edit"></i></a>
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