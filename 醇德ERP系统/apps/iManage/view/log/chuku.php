    <div id="main">
            <div class="container-fluid nopadding">

 
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script><div class="row-fluid">
<script src="/public/assets/sysadmin/js/plugins/fileupload/bootstrap-fileupload.min.js"></script>  
<div class="row-fluid">
            <div class="span12">
                <div class="box box-color box-bordered">
                    <div class="box-title">
                        <h3>
                            <i class="icon-th-list"></i>
                            出库日志
                        </h3>
                    </div>
                    <div class="box-content nopadding">
                        <table class="table table-hover table-nomargin dataTable table-bordered" width="100%">
                            <thead>
                               <tr>
                                    <th>ID</th>
                                    <th>商品名称</th>
                                    <th>操作用户</th>
                                    <th>出库位</th>
                                    <th>数量</th>
                                    <th>时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>

                            <?
                                foreach($re as $key=>$val){
                                    ?>
                                    <tr>
                                        <td><?=$val['id']?></td>
                                        <td><?=$val['title']?></td>
                                        <td><?=$val['name']?></td>
                                        <td><?=$val['mbknm']."-".$val['mbwnm']?></td>
                                        <td><?=$val['num']?></td>
                                        <td><? echo date("Y-m-d h:i:s",$val['dtime'])?></td>                                             
                                        <td>
                                            
                                           <a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("log/deleck")?>?id=<?=$val["id"]?>');" class="btn btn-small btn-danger" title="删除"><i class="icon-remove"></i></a> 
                                        </td>
                                    </tr>
                                    <?
                                }
                            ?>

                            
                           
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
 