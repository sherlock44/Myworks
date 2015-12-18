$(document).ready(function() {
    // Validation
    if ($('.form-validate').length > 0) {
        $('.form-validate').each(function() {
            var id = $(this).attr('id');
            $("#" + id).validate({
                errorElement: 'span',
                errorClass: 'help-block has-error',
                errorPlacement: function(error, element) {
                    if (element.parents("label").length > 0) {
                        element.parents("label").after(error);
                    } else {
                        element.after(error);
                    }
                },
                highlight: function(label) {
                    $(label).closest('.form-group').removeClass('has-error has-success').addClass('has-error');
                },
                success: function(label) {
                    label.addClass('valid').closest('.form-group').removeClass('has-error has-success').addClass('has-success');
                },
                onkeyup: function(element) {
                    $(element).valid();
                },
                onfocusout: function(element) {
                    $(element).valid();
                }
            });
        });
    }

    // Notifications
    $(".notify").click(function() {
        var $el = $(this);
        var title = $el.attr('data-notify-title'),
            message = $el.attr('data-notify-message'),
            time = $el.attr('data-notify-time'),
            sticky = $el.attr('data-notify-sticky'),
            overlay = $el.attr('data-notify-overlay');

        $.gritter.add({
            title: (typeof title !== 'undefined') ? title : 'Message - Head',
            text: (typeof message !== 'undefined') ? message : 'Body',
            image: (typeof image !== 'undefined') ? image : null,
            sticky: (typeof sticky !== 'undefined') ? sticky : false,
            time: (typeof time !== 'undefined') ? time : 3000
        });
    });

});


/**
swf上传完回调方法
uploadid dialog id
name dialog名称
textareaid 最后数据返回插入的容器id
funcName 回调函数
args 参数
module 所属模块
catid 栏目id
authkey 参数密钥，验证args
**/
function flashupload(uploadid, name, textareaid, funcName, args, authkey) {
    var args = args ? '&args=' + args : '';
    var setting = '&authkey=' + authkey;
    
    art.dialog.open('/index.php?a=swfupload&m=Attachments&g=Attachment' + args + setting, {
        title: name,
        id: uploadid,
        width: '650px',
        height: '420px',
        lock: true,
        fixed: true,
        background: "#CCCCCC",
        opacity: 0,
        ok: function () {
            if (funcName) {
                funcName.apply(this, [this, textareaid]);
            } else {
                submit_ckeditor(this, textareaid);
            }
        },
        cancel: true
    });
}

function imageupload(){
	$('#imgfile').click();
	$('#pic').val("");
}

//多图上传，SWF回调函数
function change_images(uploadid, returnid) {
    var d = uploadid.iframe.contentWindow;
    var in_content = d.$("#att-status").html().substring(1);
    var in_filename = d.$("#att-name").html().substring(1);
    var str = $('#' + returnid).html();
    var contents = in_content.split('|');
    var filenames = in_filename.split('|');
    $('#' + returnid + '_tips').css('display', 'none');
    if (contents == '') return true;
    $.each(contents, function(i, n) {
        var ids = parseInt(Math.random() * 10000 + 10 * i);
        var filename = filenames[i].substr(0, filenames[i].indexOf('.'));
        str += "<div id='image" + ids + "'><div class='col-sm-5'><input type='text' name='" + returnid + "_url[]' value='" + n + "' class='form-control' ondblclick='image_priview(this.value);'></div><div class='col-sm-4'><input type='text' name='" + returnid + "_alt[]' value='" + filename + "' class='form-control' onfocus=\"if(this.value == this.defaultValue) this.value = ''\" onblur=\"if(this.value.replace(' ','') == '') this.value = this.defaultValue;\"></div><div class='col-sm-3'><a class='btn btn-danger' href=\"javascript:remove_div('image" + ids + "')\">移除</a></div></div>";
    });

    $('#' + returnid).html(str);
}

//图片上传回调
function submit_images(uploadid, returnid) {
    var d = uploadid.iframe.contentWindow;
    var in_content = d.$("#att-status").html().substring(1);
    var in_content = in_content.split('|');
    IsImg(in_content[0]) ? $('#' + returnid).attr("value", in_content[0]) : alert('选择的类型必须为图片类型');
}

//验证地址是否为图片
function IsImg(url) {
    var sTemp;
    var b = false;
    var opt = "jpg|gif|png|bmp|jpeg";
    var s = opt.toUpperCase().split("|");
    for (var i = 0; i < s.length; i++) {
        sTemp = url.substr(url.length - s[i].length - 1);
        sTemp = sTemp.toUpperCase();
        s[i] = "." + s[i];
        if (s[i] == sTemp) {
            b = true;
            break;
        }
    }
    return b;
}

//验证地址是否为Flash
function IsSwf(url) {
    var sTemp;
    var b = false;
    var opt = "swf";
    var s = opt.toUpperCase().split("|");
    for (var i = 0; i < s.length; i++) {
        sTemp = url.substr(url.length - s[i].length - 1);
        sTemp = sTemp.toUpperCase();
        s[i] = "." + s[i];
        if (s[i] == sTemp) {
            b = true;
            break;
        }
    }
    return b;
}

//添加地址
function add_multifile(returnid) {
    var ids = parseInt(Math.random() * 10000);
    var str = "<li id='multifile" + ids + "'><input type='text' name='" + returnid + "_fileurl[]' value='' style='width:310px;' class='input'> <input type='text' name='" + returnid + "_filename[]' value='附件说明' style='width:160px;' class='input'> <a href=\"javascript:remove_div('multifile" + ids + "')\">移除</a> </li>";
    $('#' + returnid).append(str);
}

function reload_cache(url){
    $.getJSON(url, function(json, textStatus) {
        $.gritter.add({
            title: json.info,
            text: json.data,
            image: null,
            sticky: false,
            time: 3000
        });
    });
}

function build_index(url){
    $.getJSON(url, function(json, textStatus) {
        $.gritter.add({
            title: json.info,
            text: json.data,
            image: null,
            sticky: false,
            time: 3000
        });
    });
}

//移除指定id内容
function remove_div(id) {
    $('#' + id).remove();
}