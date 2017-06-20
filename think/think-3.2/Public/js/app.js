// JavaScript Document
$(function () {
    //******************************************//radio checkbox 美化***********************************///

    $('input').iCheck({
        checkboxClass: 'icheckbox_minimal-grey',
        radioClass: 'iradio_minimal-grey',
        increaseArea: '20%', // optional
    });
    //**********************//验证美化验证问题***********************************///

    $('input').on('ifChanged', function () {
        $('input[name="' + $(this).attr('name') + '"]').trigger('blur');
    })
    //***********************//删除多个选择***********************************///

    $('#sel-all').on('ifClicked', function () {
        $('table input:checkbox').iCheck('check');
    }).on('ifUnchecked', function () {
        $('table input:checkbox').iCheck('uncheck');
    });
    //***********************//checkbox switch***********************************///

    $('.switch-checkbox').bootstrapSwitch({'size': 'smaoll', "onColor": 'success', 'offColor': 'warning'});
    //************************返回顶部***********************************///
    $('#goTop').click(function () {
        $('html,body').animate({
            scrollTop: '0'
        }, 300);
    });
    //*******************//删除多个提交***********************************///

    $('#removeAll').click(function () {
        $this = $(this);
        msg.confirm('确定要删除这些数据？', '', {okhandle: function () {
                var chks = $(".checkbox-sel:checked");
                if (chks.length <= 0) {
                    msg.alert('没有选择任何数据');
                    return false;
                }
                var ids = Array();
                chks.each(function () {
                    ids.push($(this).val());
                });
                $.post($this.attr('to'), {ids: ids}, function (data) {
                    if (data.status) {
                        location.reload();
                    } else {
                        msg.alert(data.info, '', {type: 'danger'});
                    }
                })
            }
        })
    });

    //*********************************更改状态*******************************************/
    $('#changeStatus0,#changeStatus1').click(function () {
        $this = $(this);
        msg.confirm('更改这些数据的状态？', '', {okhandle: function () {
                var chks = $(".checkbox-sel:checked");
                if (chks.length <= 0) {
                    msg.alert('没有选择任何数据');
                    return false;
                }
                var ids = Array();
                chks.each(function () {
                    ids.push($(this).val());
                });
                $.post($this.attr('to'), {ids: ids}, function (data) {
                    if (data == 'y') {
                        location.reload();
                    } else {
                        msg.alert(data, '', {type: 'danger'});
                    }
                })
            }
        })
    });

    //******************************************搜索类型变更***********************************///
    $('#search_stype').change(function () {
        var v = $(this).val();
        swhtype(v);
    });
    swhtype(search_type);
    //******************************************搜索类型变更   函数***********************************///
    function swhtype(v) {
        if ($('#' + v)[0]) { //有对象 显示
            
            $('#search_form div.form-group').hide();
            $('#search_form div.form-group').hide().find('input,select').attr('disabled');
            $('#' + v).show().find('input,select').removeAttr("disabled");
        } else { //没有显示默认的 输入框
            $('#search_form div.form-group').hide().find('select').attr('disabled');
            $('#search_form div.form-group').find('input').removeAttr('disabled').parent().show();
        }
    }
    //******************************************更新排序***********************************///
    $('#resort').click(function () {
        var ids = Array();
        var val = Array();
        $('table .t_sort').each(function () {
            ids.push($(this).attr('ids'));
            val.push($(this).val());
        })
        $.post($(this).attr('to'), {ids: ids, val: val}, function (data) {
            if (data == 'y') {
                msg.alert('更新成功', '', {type: 'success'});
            } else {
                msg.alert(data, '', {type: 'danger'});
            }
        })
    })
    /*******************************显示图片**************************************************///
    $('.show-photo').click(function () {
        var img_url = $(this).attr('data-photo');
        var img = new Image();
        img.src = img_url
        img.onload = function () {
            var w = img.width + 30;
            var str = '<div class="modal fade" id="img-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\
            <div class="modal-dialog" style="width:' + w + 'px"><div class="modal-content"><div class="modal-header">\
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
            <h4 class="modal-title" id="myModalLabel">图片显示</h4>\
            </div><div class="modal-body"><img src="' + img_url + '"/></div></div></div></div>';
            $('body').append(str);
            $('#img-modal').modal();
        }
    });

});
