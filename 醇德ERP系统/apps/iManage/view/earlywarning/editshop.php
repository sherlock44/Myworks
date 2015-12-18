<div id="main">
    <div class="container-fluid nopadding">
        <script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/kindeditor-min.js"></script>
        <script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/lang/zh_CN.js"></script>
        <script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/php/upload_json.php"></script>
        <script>
            var editor;
            KindEditor.ready(function(K) {
                editor = K.create('textarea[name="remark"]', {
                    allowFileManager : true,
                    afterBlur: function(){this.sync();}
                });
//            editor = K.create('textarea[name="basicinfo"]', {
//                    allowFileManager : true
//            });
//            editor = K.create('textarea[name="traffic"]', {
//                    allowFileManager : true
//            });
//            editor = K.create('textarea[name="service"]', {
//                    allowFileManager : true
//            });
//            editor = K.create('textarea[name="ambient"]', {
//                    allowFileManager : true
//            });
//            editor = K.create('textarea[name="special"]', {
//                    allowFileManager : true
//            });
            });
        </script>
        <div class="breadcrumbs">
            <ul>
                <li>
                    <a href="<?=$_SESSION['indexmain']?>">后台管理</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="">预警管理</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href=""><?=!empty($re)?"预警修改":"添加商品"?></a>
                </li>
            </ul>
            <div class="close-bread">
                <a href="#"><i class="fa fa-close"></i></a>
            </div>
        </div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
        <script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
        <script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script><div class="row-fluid">


            <link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/chosen/chosen.css">
            <script src="/public/assets/sysadmin/js/plugins/chosen/chosen.jquery.min.js"></script>
            <script src="/public/assets/sysadmin/js/plugins/ckeditor/ckeditor.js"></script>
            <link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datetimepicker/datetimepicker.css">
            <script src="/public/assets/sysadmin/js/plugins/datetimepicker/datetimepicker.js"></script>
            <script src="/public/assets/sysadmin/js/plugins/datetimepicker/locales/bootstrap-datetimepicker.zh-CN.js"></script>
            <script src="/public/assets/sysadmin/js/plugins/kindeditor/kindeditor-min.js"></script>
            <link rel="stylesheet" href="/public/js/plugins/kindeditor/themes/default/default.css" />
            <script src="/public/assets/sysadmin/js/plugins/fileupload/bootstrap-fileupload.min.js"></script>
            <div class="row-fluid">
                <div class="span12">
                    <div class="box box-color box-bordered">
                        <div class="box-title">
                            <h3>
                                <i class="icon-user"></i>
                            </h3>
                        </div>
                        <div class="box-content nopadding">
                            <form  class='form-horizontal form-bordered form-validate'  action='<?=$this->url("earlywarning/update")?>'  id="login" name="login" method='post'>
                                <div class="control-group">
                                    <label for="mobile" class="control-label">商品名称</label>
                                    <div class="controls">
                                        <input readonly type="text" name="data[title]" id="title" value="<?=!empty($re) ? $re["title"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                                    </div>
                                <div class="control-group">
                                    <label for="mobile" class="control-label">拼音码</label>
                                    <div class="controls">
                                        <input readonly type="text" name="data[pingyincode]" id="pingyincode" value="<?=!empty($re) ? $re["pingyincode"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="mobile" class="control-label">供应商</label>
                                    <div class="controls">
                                        <input readonly type="text" name="data[supplier]" id="supplier" value="<?=!empty($re) ? $re["supplier"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="mobile" class="control-label">保质期</label>
                                    <div class="controls">
                                        <input type="text" name="data[shelflife]" id="shelflife" value="<?=!empty($re) ? $re["shelflife"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-number="true" data-rule-minlength="1" placeholder="只能填数字">(天)
                                    </div>
                                     <div class="control-group">
                                    <label for="mobile" class="control-label">逾期预警下限</label>
                                    <div class="controls">
                                        <input type="text" name="data[beoverdue]" id="beoverdue" value="<?=!empty($re) ? $re["beoverdue"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">

                                    </div>

                                </div>
                                <div class="control-group">
                                    <label for="mobile" class="control-label">库存</label>
                                    <div class="controls">
                                        <input readonly type="text" name="data[number]" id="number" value="<?=!empty($re) ? $re["number"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">

                                    </div>

                                </div>
                                <div class="control-group">
                                    <label for="mobile" class="control-label">库存预警下限</label>
                                    <div class="controls">
                                        <input type="text" name="data[numberone]" id="numberone" value="<?=!empty($re) ? $re["numberone"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                                    </div>
                             </div>
                                <input type='hidden'  name="id" value='<?=!empty($re) ? $re['id']: ''?>'>
                                <div class="form-actions">
                                    <input type="submit" class="btn btn-primary" value="提交" >
                                    <input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //返回列表
    function returnList(){
        window.location.href='<?=$this->url("earlywarning/Inventory")?>';
    }

</script>
