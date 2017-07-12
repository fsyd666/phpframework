$(function () {
    $('#id-auth-checkbox .check-div input:checkbox').change(function () {
        var label = $(this).parent();
        var index = label.index();
        if (index == 0) {
            if ($(this).is(':checked')) {
                label.siblings().find('input:checkbox').prop('checked', true);
            } else {
                label.siblings().find('input:checkbox').prop('checked',false);
            }
        } else {
            if ($(this).is(':checked')) {
                label.siblings().first().find('input:checkbox').prop('checked', true);
            }
        }
    });
    $('#selAll').change(function () {
        var checkboxs = $(this).parents('table').find('.checkbox-sel')
        if ($(this).is(':checked')) {
            checkboxs.attr('checked', 'checked');
        } else {
            checkboxs.removeAttr('checked', 'checked');
        }
    });
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
                $.post($this.attr('href'), {id: ids}, function (data) {
                    console.log(data);
                    if (data.status) {
                        location.reload();
                    } else {
                        msg.alert(data.info, '', {type: 'danger'});
                    }
                }, "json");
            }
        })
        return false;
    });
})