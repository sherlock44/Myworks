<section class="content-header">
    <h1>
        站内信
        <small>站内信详情</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
        <li><a href="#">通用管理</a></li>
        <li class="active">站内信</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default">
        <div class="box-header">
            <h3 class="box-title">请选择要发送站内信的用户</h3>
        </div>
        <div class="box-body row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">标题</label>
                    <input type="text" readonly="readonly" value="<?=$re['title']?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="number">内容</label>
                    <textarea rows="3" readonly="readonly" data-rule-required="true" name="data[content]" data-rule-minlength="8" class="form-control"><?=$re['content']?></textarea>
                </div>
                <div class="form-group">
                    <label for="password">发送时间</label>
                    <input type="text" readonly="readonly"   value="<? echo date("Y-m-d h:i:s",$re['time'])?>"   class="form-control"  data-rule-required="true" data-rule-minlength="6">
                </div>
                <div class="form-group">
                    <label for="password">信息接收者</label>
                    <hr>
                    <?php foreach ($rs as $key => $val){ ?>
                    <label style=" padding-right: 5px;"> 
                        <?if($val['type']==1){?>
                        <?=$val['glynm']?>(管理员)
                        <?}else{?>
                        <?=$val['jmsnm']?>(加盟商)
                        <?}?>
                    </label>
                    <?php } ?>   
                </div>
            </div> 
        </div>
        <div class="box-footer">
            <input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>
        </div>
    </div>
</section>
<script>
//返回列表
function returnList(){
    window.location.href='<?=$this->url("General/statWithinfo")?>';
}
</script>