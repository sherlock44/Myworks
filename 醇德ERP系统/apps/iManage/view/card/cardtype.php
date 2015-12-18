<div id="main">
    <div class="container-fluid">
        <div class="page-header">
            <div class="pull-left">
                <h1>生成会员卡类型</h1>
            </div>
            <div class="pull-right">
                <ul class="stats">
                    <li class='lightred'>
                        <i class="icon-calendar"></i>
                        <div class="details">
                            <span class="big"></span>
                            <span></span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
<script type="text/javascript">
function currentTime(){
    var $el = $(".stats .icon-calendar").parent(),
    currentDate = new Date(),
    monthNames = [1,2,3,4,5,6,7,8,9,10,11,12],
    dayNames = ["周日","周一","周二","周三","周四","周五","周六"];

    $el.find(".details span").html(currentDate.getFullYear() + " - " + monthNames[currentDate.getMonth()] + " - " + currentDate.getDate());
    $el.find(".details .big").last().html(currentDate.getHours()+":"+ ("0" + currentDate.getMinutes()).slice(-2) + ", " + dayNames[currentDate.getDay()]);
    setTimeout(function(){
        currentTime();
    }, 10000);
}
currentTime();
</script>
<div class="breadcrumbs">
    <ul>
        <li>
            <a href="<?=$_SESSION['indexmain']?>">后台管理</a>
            <i class="icon-angle-right"></i>
        </li>
        <li>
            <a href="">系统管理</a>
            <i class="icon-angle-right"></i>
        </li>
        <li>
            <a href="">会员卡管理</a>
        </li>
    </ul>
    <div class="close-bread">
        <a href="#"><i class="fa fa-close"></i></a>
    </div>
</div>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/chosen/chosen.css">
<script src="/public/assets/sysadmin/js/plugins/chosen/chosen.jquery.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/jquery.dataTables.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/TableTools.css">
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/TableTools.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColReorder.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColVis.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.columnFilter.js"></script>
        <div class="row-fluid">
            <div class="span12">
                <div class="box box-color box-bordered">
                    <div class="box-title">
                        <h3>
                            <i class="icon-th-list"></i>
                            生成会员卡类型
                        </h3>
                    </div>
                    <div class="box-content nopadding">
                        <form  class='form-horizontal form-bordered form-validate' action='<?=$this->url("card/add_cardtype")?>'  id="login" name="login" method='post'>    
                            <div class="control-group">
                                <label for="password" class="control-label">会员卡类型</label>
                                <div class="controls">
                                    <input type="text" name="data[title]" id="title" placeholder="请填写会员卡类型名称,如：金卡" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" class="btn btn-primary" value="生成会员卡类型">&nbsp;&nbsp;&nbsp;
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>