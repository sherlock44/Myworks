<section class="content-header">
<h1>
  邮件详情
  <small>邮件推送记录</small>
</h1>
<ol class="breadcrumb">
  <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
  <li><a href="#">通用管理</a></li>
  <li class="active">邮件推送</li>
</ol>
</section>
<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">邮件内容</h3>
        </div>
        <div class="box-body no-padding">
            <div class="mailbox-read-info">
                <h3><?=$re['title']?></h3>
                <h5>发送给: support@almsaeedstudio.com <span class="mailbox-read-time pull-right"><? echo date("Y-m-d h:i:s",$re['time'])?></span></h5>
            </div><!-- /.mailbox-read-info -->
             <div class="mailbox-read-message">
                <p><?=$re['content']?></p>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="form-actions">
                <input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>
            </div>
        </div>
    </div>
</section>
<script>
    function returnList(){
        window.location.href='<?=$this->url("General/maillist")?>';
    }
</script>