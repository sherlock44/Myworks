<section class="content-header">
    <h1>
        重置会员卡密码
        <small>重置会员卡密码</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> 后台管理</a></li>
        <li><a href="#">会员卡管理</a></li>
        <li class="active">重置会员卡密码</li>
    </ol>
</section>
<section class="content">
    <form class="box box-default form-validate" action='<?= $this->url("card/changepwd",array('id'=>$id))?>'  id="myform" method='post'>
        <div class="box-header">
            <h3 class="box-title">请输入会员重置密码</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label>卡号</label>
                        <?=$re['cardnum']?>
                    </div>
                    <div class="form-group">
                        <label for="password">新密码</label>
                        <input type="text" name="password" value="" class="form-control" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
                    </div>
                    <div class="form-group">
                        <label for="pwd">确认密码</label>
                        <input type="text" name="pwd" value="" class="form-control" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <input type="hidden" value="<?= !empty($re) ? $re['id'] : '' ?>" name="id">
            <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> 提交</button>
            <button class="btn btn-default" type="button" onclick="returnList()"><i class="fa fa-reply"></i> 返回</button>
        </div>
    </form>
</section>
<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<script>
//返回列表
function returnList(){
    window.location.href="<?=$this->url('user/franchisee')?>";
}
</script>
