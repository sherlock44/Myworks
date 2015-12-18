<section class="content-header">
    <h1>
        批量生成会员卡
        <small>批量生成会员卡</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
        <li><a href="#">会员卡管理</a></li>
        <li class="active">批量生成会员卡</li>
    </ol>
</section>
<section class="content">
    <form class="box box-default form-validate" action='<?=$this->url("card/addcard")?>'  id="myform" method='post'>
        <div class="box-header with-border">
            <h3 class="box-title">会员卡折扣规则</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="cardtype">会员卡类型</label>
                        <select name="data[cardtype]" class="form-control">
                            <option>请选择会员卡类型</option>
                            <?foreach ($card as $k => $v) {?>
                            <option value=<?=$k?>><?=$v?></option>
                            <? }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="num">选择数量</label>
                        <input type="text" name="data[num]" id="num" placeholder="请填写数字" class="form-control" data-rule-required="true" data-rule-minlength="1">
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="form-actions">
                <input type="submit" class="btn btn-success" value="提交" >
            </div>
        </div>
    </form>
</section>
<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>