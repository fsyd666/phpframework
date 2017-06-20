var uploadify_onSelectError = function(file, errorCode, errorMsg) {
    switch (errorCode) {
        case -100:
            msg.alert("最多只能上传" + $('#mute_file_upload').uploadify('settings', 'uploadLimit') + "张图片！");
            break;
        case -110:
            msg.alert("文件 [" + file.name + "] 大小超出系统限制的" + $('#file_upload').uploadify('settings', 'fileSizeLimit') + "大小！");
            break;
        case -120:
            msg.alert("文件 [" + file.name + "] 大小异常！");
            break;
        case -130:
            msg.alert("文件 [" + file.name + "] 类型不正确！");
            break;
    }
    return false;
};