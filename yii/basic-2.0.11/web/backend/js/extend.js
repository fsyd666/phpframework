/**
 * 对话框扩展
 */
var msg = function (obj) {
    var obj = obj;
    this.ops = {
        type: 'info',
        sucText: '确定',
        celText: '取消',
        fix: 'top',
        okhandle: function (obj) {
        },
        celhandle: function () {
        }
    };
    this.icon = {
        info: 'icon-info-sign',
        success: 'icon-ok-sign',
        warning: 'icon-warning-sign',
        danger: 'icon-warning-sign'
    }
    this.create = function (str) {
        $('.alert_div,.body_mask').remove();
        $('body').append('<div class="body_mask"></div>');//创建遮罩
        $('body').append(str);
        $('.alert_div .btn-success').on('click', sucBtnClick);
        $('.alert_div .btn-default').on('click', celBtnClick);
    }
    var sucBtnClick = function () {
        hide();
        if (obj && obj.href) {
            location.href = obj.href;
        }
        ops.okhandle(obj);
    }
    var celBtnClick = function () {
        hide();
        ops.celhandle(obj);
    }
    var hide = function () {
        $('.body_mask,.alert_div').remove();
    }
    return this;
};
msg.alert = function (tit, obj, op) {
    var m = new msg(obj);
    ops = $.extend(m.ops, op);
    var str = '<div class="alert_div alert alert-' + ops.type + ' alert-dismissable"><h4><i class="' + m.icon[ops.type] + '"></i>' + tit + '</h4><div class="clearfix"></div><div class="alert_btn pull-right">' +
            '<button type="button" class="btn btn-success">&nbsp;确定&nbsp;</button></div></div>';
    m.create(str);
    return false;

};
msg.confirm = function (tit, obj, op) {
    var m = new msg(obj);
    ops = $.extend(m.ops, op);
    var str = '<div class="alert_div alert alert-warning alert-dismissable"><h4><i class="icon-question-sign"></i>' + tit + '</h4><div class="clearfix"></div><div class="alert_btn pull-right">' +
            '<button type="button" class="btn btn-success">&nbsp;' + ops.sucText + '&nbsp;</button>&nbsp;<button type="button" class="btn btn-default">&nbsp;' + ops.celText + '&nbsp;</button></div></div>';
    m.create(str);
    return false;
};