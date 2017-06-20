//验证
$.fn.regvalid = function () {
    $(this).submit(function () {
        var input_mobile = $(this).find('input[name="mobile"]');
        var input_code = $(this).find('input[name="code"]');
        var input_mobile_verify = $(this).find('input[name="mobile_verify"]');

        //验证手机号码 (必须有的数据)
        var mobile = input_mobile.val();
        if (!/^(1)[0-9]{10}$/.test(mobile)) {
            alert("请输入正确的手机号码");
            return false;
        }

        //验证股票代码
        if (input_code.length > 0) {
            var code = input_code.val();
            if (!/^[036]{1}\d{5}$/.test(code)) {
                alert("请输入正确的股票代码");
                return false;
            }
        }
        //验证验证码
        if (input_mobile_verify.length > 0) {
            var mobile_verify = input_mobile_verify.val();
            if (mobile_verify == "") {
                alert("请输入验证码");
                return false;
            }
            //ajax验证
            var flag = false;
            $.ajax({
                type: "GET",
                dataType: "jsonp",
                url: 'http://www.zuohui.cc/regapp/ajax_check_sms?callback=?',
                data: {mobile_verify: mobile_verify, mobile: mobile},
                async: false,
                success: function (d) {
                    if (d.status == 1) {
                        flag = true;
                    } else {
                        alert(d.info);
                    }
                }
            });
            return flag;
        }
    })
}

/**
 * 
 * @returns {undefined}
 * 获取验证码 
 */
$.fn.getverify = function (o) {
    var def = {
        mobile: '',
        msg: "alert",
        time: 60,
        disabledClass: 'disabled'
    };

    o = $.extend(def, o);

    //把字符串 转换为对象
    var showMsg = eval(o.msg);

    var $this = $(this);
    if ($this.is('input')) {
        var defval = $this.val();
    } else {
        var defval = $this.text();
    }

    $this.click(function () {
        var mobile = $.trim($(o.mobile).val());
        if (!/^1[3-9]\d{9}$/.test(mobile)) {
            showMsg('手机号码为空或不正确!');
            return false;
        }
        sms_start();
        $.ajax({
            type: "GET",
            dataType: "jsonp",
            url: 'http://www.zuohui.cc/regapp/send_msg?callback=?',
            data: {mobile: mobile},
            async: true,
            success: function (d) {
                if (!d.status) {
                    clear_time();
                    showMsg(d.info);
                }
            }
        });
        return false;
    })
    var sec = parseInt(o.time);
    var sms_start = function () {
        if ($this.is("input")) {
            $this.val(sec-- + '秒');
        } else {
            $this.text(sec-- + '秒');
        }
        $this.attr('disabled', true).addClass('disabled');
        if (sec <= 0) {
            clear_time();
        }
        t = setTimeout(sms_start, 1000);
    }
    var clear_time = function () {

        if ($this.is("input")) {
            $this.val(defval);
        } else {
            $this.text(defval);
        }
        $this.removeAttr('disabled').removeClass('disabled');
        sec = parseInt(o.time);
        clearTimeout(t);
        return true;
    }
}


