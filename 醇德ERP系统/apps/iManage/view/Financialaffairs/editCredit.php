<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<section class="content-header">
    <h1>
        加盟商信用管理
        <small>修改加盟商信用额度</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> ERP系统</a></li>
        <li><a href="#">财务管理</a></li>
        <li class="active">加盟商信用管理</li>
    </ol>
</section>
<section class="content">
    <form class='box form-validate form-confirm' action='<?= $this->url("Financialaffairs/updateCredit") ?>' id="login" name="login" method='post'>
        <div class="box-header with-border">
            <h3 class="box-title">请填写意向客户信息</h3>
            <div class="box-tools pull-right">
                <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="mobile">客户类型</label>
                    <br>
                    <?=$re['ctitle']?>
                </div>
                <div class="form-group">
                    <label for="mobile">公司名称</label>
                    <br>
                    <?=$re['commname']?>
                </div>
                <div class="form-group">
                    <label for="mobile">信用额度</label>
                    <input type="text" name="data[creditline]" value="<?=$re['creditline']?>" class="form-control"
                    data-rule-required="true" id="xyed" data-rule-minlength="1">
                </div>
                <div class="form-group">
                    <label for="mobile">当前信用额度</label>
                    <input type="text" name="data[canusemoney]" class="form-control" value="<?=$re['canusemoney']?>" class="span1"
                    data-rule-required="true" id="dqed"  data-rule-minlength="1" placeholder="当前可用额度包含信用额度">
                </div>
                <div class="form-group">
                    <label for="mobile">备注</label>
                    <textarea class="form-control" name="note"></textarea>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <input type="hidden" id="ednum" value="<?=$re['creditline']?>">
            <input type="hidden" id="dqednum" value="<?=$re['canusemoney']?>">
            <input type="hidden" value="<?=$id?>" name="id">
            <input type="submit" class="btn btn-primary" value="保存">
            <input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>
        </div>
    </form>
</section>
<script>
    function returnList(){
        window.location.href='<?=$this->url("Financialaffairs/banklist")?>';
    }
</script>
<?if($log){?>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-th-list"></i>
                    信用额度操作记录
                </h3>
                <div class="actions">
                    <a rel="tooltip"  href="javascript:void(0)" id="logtag" onclick="javascript:if($('#logcontent')[0].style.display=='none'){$('#logcontent').show();$('#logtag').html('-');}else{$('#logcontent').hide();$('#logtag').html('+');}"  class="btn btn-danger">+</a>
                </div>
            </div>
            <div class="box-content nopadding" id="logcontent" style="display:none;">
                <div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
                    <table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="10%">序号</th>
                                <th width="10%">修改人</th>
                                <th width="10%">修改内容内容</th>
                                <th width="10%">备注</th>                         
                                <th width="15%">修改时间</th>
                            </tr>
                        </thead>
                        <?foreach($log as $ks=>$value){?>
                        <tr>
                            <td><?=$value['id']?></td>
                            <td><?=$value['name']?></td>
                            <td><?=$value['editcont']?></td>
                            <td><?=$value['note']?></td>  
                            <td><?=date("Y-m-d H:i:s",$value['time'])?></td>                 
                        </tr>
                        <?}?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?}?>
<script>
//返回列表
function returnList(){
    window.location.href="<?=$this->url('Financialaffairs/creditManage')?>";
}
</script>
<script type="text/javascript">
    $(function(){
        $("#xyed").blur(function(){
            var ed     = parseFloat($(this).val());
            var ned    = parseFloat($("#ednum").val());
            var dqed   = parseFloat($("#dqed").val());
            var updt   = ed-ned+dqed;
            $("#ednum").val(ed);
            $("#dqed").val(updt);          
//alert($("#ednum").val());
//alert(ed-0.00);
//var upda   = ed-$("#ednum").val()+$("#dqednum").val();
// alert(upda);
});
    });
</script>
