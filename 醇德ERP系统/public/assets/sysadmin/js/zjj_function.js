function pub_alert_error(msg) {
    msg = msg ? msg : '错误';
    bootbox.alert(msg);
}

function pub_alert_success(msg) {
    msg = msg ? msg : '操作成功';
    bootbox.alert(msg);
}

function lock_screen(url) {
    var url = url == undefined ? HINDEX_MASTER + 'login/lock' : url;
    var data = $("#form_locked").serialize();
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        dataType: 'json',
        success: function(r) {
            if (r.state == 1) {
                location.reload();
            } else {
                pub_alert_error(r.info);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("系统出错，错误:" + textStatus);
        }
    });
    if (url != HINDEX_MASTER + 'login/lock') {
        return false;
    }
}

function pub_alert_confirm(t, msg, url) {
    if (!t || !url) return false;
    msg = msg ? msg : '确定要执行此操作吗？';
    bootbox.confirm(msg, function(r) {
        if (r) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(result) {
                    if (result.state == 1) {
                        pub_alert_success(result.info);
                        if (result.data == 'back') {
                            setTimeout('history.go(-1)', 600);
                        } else if (result.data == 'url') {
                            window.location.href = result.url;
                        } else if (result.data == "delnum") {
                            $("." + result.className).val('');
                        } else {
                            setTimeout('location.reload()', 600);
                        }
                    } else {
                        pub_alert_error(result.info);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("系统出错，错误:" + textStatus);
                }
            });
}
});
}

function pub_ajax_submit(form) {
    if (!form) return false;
    
    $(form).ajaxSubmit({
        type:'POST',
        dataType:'json',
        success:function(r){

           if (r.state == 1) {
            pub_alert_success(r.info);
            if (r.data == 'back') {
                setTimeout('history.go(-1)', 600);
            } else if (r.data == 'url') {
                window.location.href = r.url;

            } else if (r.data == "delnum") {
                $("." + r.className).val('');
                $("." + r.btClassName).html(r.btstr);
            } else {
                setTimeout('location.reload()', 600);
                   // location.reload();
               }
           } else {
            pub_alert_error(r.info);
            if (r.data = "delnum") {
                $("." + r.btClassName).html(r.btstr);
            }
        }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert("系统出错，错误:" + textStatus);
    }
});
    
    
    
    
    
    
    
    /* var data = $(form).serialize();
    
    $.ajax({
        type: 'post',
        data: data,
        url: form.action,
        dataType: 'json',
        success: function(r) {
                
            if (r.state == 1) {
                pub_alert_success(r.info);
                if (r.data == 'back') {
                    setTimeout('history.go(-1)', 600);
                } else if (r.data == 'url') {
                    window.location.href = r.url;
                    
                } else if (r.data == "delnum") {
                    $("." + r.className).val('');
                    $("." + r.btClassName).html(r.btstr);
                } else {
                    location.reload();
                }
            } else {
                pub_alert_error(r.info);
                if (r.data = "delnum") {
                    $("." + r.btClassName).html(r.btstr);
                }
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("系统出错，错误:" + textStatus);
        }
    }); */
}

function pub_ajax_submit_confirm(form, msg) {
    if (!form) return false;
    msg = msg ? msg : '确定要执行此操作吗？';
    bootbox.confirm(msg, function(r) {
        if (r) {
            $(form).ajaxSubmit({
                type:'POST',
                dataType:'json',
                success: function(r) {
                    if (r.state == 1) {
                        pub_alert_success(r.info);
                        if (r.data == 'back') {
                            setTimeout('history.go(-1)', 600);
                        } else if (r.data == 'url') {
                            window.location.href = r.url;
                        } else if (r.data == "delnum") {
                            $("." + r.className).val('');
                            $("." + r.btClassName).html(r.btstr);
                        } else {
                            setTimeout('location.reload()', 600);
                        }
                    } else {
                        pub_alert_error(r.info);
                        if (r.data = "delnum") {
                            $("." + r.btClassName).html(r.btstr);
                        }
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("系统出错，错误:" + textStatus);
                }
            });
}
});
}

/* function pub_ajax_submit_confirm(form, msg) {
    if (!form) return false;
    msg = msg ? msg : '确定要执行此操作吗？';
    bootbox.confirm(msg, function(r) {
        if (r) {
            var data = $(form).serialize();
            $.ajax({
                type: 'post',
                data: data,
                url: form.action,
                dataType: 'json',
                success: function(r) {
                    if (r.state == 1) {
                        pub_alert_success(r.info);
                        if (r.data == 'back') {
                            setTimeout('history.go(-1)', 600);
                        } else if (r.data == 'url') {
                            window.location.href = r.url;
                        } else if (r.data == "delnum") {
                            $("." + r.className).val('');
                            $("." + r.btClassName).html(r.btstr);
                        } else {
                            location.reload();
                        }
                    } else {
                        pub_alert_error(r.info);
                        if (r.data = "delnum") {
                            $("." + r.btClassName).html(r.btstr);
                        }
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("系统出错，错误:" + textStatus);
                }
            });
        }
    });
} */

function pub_submit_ck() {
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
}

function pub_alert_html(url, isjump, addvar) {
    addvar = addvar ? '&' : '?';
    isjump ? location.href = url + addvar + UVAR : '';
    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        success: function(r) {
            if (r.state == 1) {

                $('body').prepend(r.data);
                _pub_alert_bootbox();
            } else {
                pub_alert_error(r.info);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("系统出错，错误:" + textStatus);
        }
    })
}

function _pub_alert_bootbox() {
    $("#pub_edit_bootbox").on("show", function() {
        $("#pub_edit_bootbox a.btn").on("click", function(e) {
            console.log("button pressed");
            $("#pub_edit_bootbox").modal('hide');
        });
    });
    $("#pub_edit_bootbox").on("hide", function() {
        $("#pub_edit_bootbox a.btn").off("click");
    });
    $("#pub_edit_bootbox").on("hidden", function() {
        $("#pub_edit_bootbox").remove();
    });
    $("#pub_edit_bootbox").modal({
        "backdrop": "static",
        "keyboard": true,
        "show": true
    });
}

function bindSelect(url, name) {
    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        success: function(r) {
            $("#" + name).append("<option value='0'>请选择</option>");
            for (key in r) {
                $("#" + name).append("<option value='" + r[key].id + "'>" + r[key].name + "</option>");
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("系统出错，错误:" + textStatus);
        }
    })
}
(function() {
    bootbox.setDefaults({
        locale: "zh_CN"
    });
});