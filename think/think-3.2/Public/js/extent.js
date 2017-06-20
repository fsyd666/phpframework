/**
 * 验证插进扩展
 */
var _6 = function(msg, o, cssctl) {
    //msg：提示信息;
    //o:{obj:*,type:*,curform:*},
    //obj指向的是当前验证的表单元素（或表单对象，验证全部验证通过，提交表单时o.obj为该表单对象），
    //type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, 
    //curform为当前form对象;
    //cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
    if (!o.obj.is("form")) {
        // alert(111);
        var pt = o.obj.parents('.form-group'); //获取父元素
        if (o.obj.is(':checkbox,:radio')) {
            o.obj.parents("[class^='col-sm-']").css({width: 'initial'});
        }
        switch (o.type) {
            case 2://成功
                pt.removeClass('has-error').addClass('has-success');
                break;
            case 3://失败
                pt.removeClass('has-success').addClass('has-error');
                //$(window).scrollTop(0)//滚动到顶部
                break;
        }
        if (pt.find(".help-block").length == 0) {
            pt.append("<span class='help-block' />");
        }
        var objtip = pt.find(".help-block");
        cssctl(objtip, o.type);
        objtip.text(msg);
    }
};
/**
 * 对话框扩展
 */
var msg = function(obj) {
    var obj = obj;
    this.ops = {
        type: 'info',
        sucText: '确定',
        celText: '取消',
        fix: 'top',
        okhandle: function(obj) {
        },
        celhandle: function() {
        }
    };
    this.icon = {
        info: 'icon-info-sign',
        success: 'icon-ok-sign',
        warning: 'icon-warning-sign',
        danger: 'icon-warning-sign'
    }
    this.create = function(str) {
        $('.alert_div,.body_mask').remove();
        $('body').append('<div class="body_mask"></div>');//创建遮罩
        $('body').append(str);
        $('.alert_div .btn-success').on('click', sucBtnClick);
        $('.alert_div .btn-default').on('click', celBtnClick);
    }
    var sucBtnClick = function() {
        hide();
        if (obj && obj.href) {
            location.href = obj.href;
        }
        ops.okhandle(obj);
    }
    var celBtnClick = function() {
        hide();
        ops.celhandle(obj);
    }
    var hide = function() {
        $('.body_mask,.alert_div').remove();
    }
    return this;
};
msg.alert = function(tit, obj, op) {
    var m = new msg(obj);
    ops = $.extend(m.ops, op);
    var str = '<div class="alert_div alert alert-' + ops.type + ' alert-dismissable"><h4><i class="' + m.icon[ops.type] + '"></i>' + tit + '</h4><div class="clearfix"></div><div class="alert_btn pull-right">' +
            '<button type="button" class="btn btn-success">&nbsp;确定&nbsp;</button></div></div>';
    m.create(str);
    return false;

};
msg.confirm = function(tit, obj, op) {
    var m = new msg(obj);
    ops = $.extend(m.ops, op);
    var str = '<div class="alert_div alert alert-warning alert-dismissable"><h4><i class="icon-question-sign"></i>' + tit + '</h4><div class="clearfix"></div><div class="alert_btn pull-right">' +
            '<button type="button" class="btn btn-success">&nbsp;' + ops.sucText + '&nbsp;</button>&nbsp;<button type="button" class="btn btn-default">&nbsp;' + ops.celText + '&nbsp;</button></div></div>';
    m.create(str);
    return false;
};
/**
 * Jqury toggle函数
 * @param {type} fn
 * @param {type} fn2
 * @returns {jQuery.fn@call;click}
 */
$.fn.toggle = function(fn, fn2) {
    var args = arguments, guid = fn.guid || $.guid++, i = 0,
            toggler = function(event) {
                var lastToggle = ($._data(this, "lastToggle" + fn.guid) || 0) % i;
                $._data(this, "lastToggle" + fn.guid, lastToggle + 1);
                event.preventDefault();
                return args[ lastToggle ].apply(this, arguments) || false;
            };
    toggler.guid = guid;
    while (i < args.length) {
        args[ i++ ].guid = guid;
    }
    return this.click(toggler);
};