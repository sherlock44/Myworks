<section class="content-header">
    <h1>
        商品品牌
        <small>商品品牌管理</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"> <i class="fa fa-home"></i>
                ERP系统
            </a>
        </li>
        <li>
            <a href="">商品管理</a>
        </li>
        <li class="active">商品品牌</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">品牌列表</h3>
                    <div class="box-tools pull-right">
                        <a href="<?=$this->url('goods/addbrand')?>" class="btn btn-default btn-sm"> <i class="fa fa-plus"></i>
                            添加
                        </a>
                        <a href="<?=$this->url('goods/brandin')?>" class="btn btn-default btn-sm"> <i class="fa fa-cloud-upload"></i>
                            品牌导入
                        </a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-init">
                            <thead>
                                <tr>
                                    <th style="display:none;">排序</th>
                                    <th>ID</th>
                                    <th>名称(中文)</th>
                                    <th>名称(英文)</th>
                                    <th>图标</th>
                                    <th>简介</th>
                                    <th>排序</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <?foreach($re as $key=>$val){?>
                            <tr>
                                <td style="display:none;"><?=$val['sort']?></td>
                                <td><?=$val['id']?></td>
                                <td><?=$val['title']?>&nbsp;&nbsp;</td>
                                <td><?=$val['title_en']?>&nbsp;&nbsp;</td>
                                <td><img src="<?=empty($val["icon"])?"/public/assets/sysadmin/img/default.png":$val["icon"]?>" style="width:50px;height:50pw;"></td>
                                <td><?=$val['intro']?></td>
                                <td><?=$val['sort']?></td>
                                <td>
                                    <a class="btn btn-xs btn-success" href="<?=$this->url('goods/editbrand',array('id'=>$val['id']))?>"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("goods/delbrand")?>?id=<?=$val["id"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?}?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>