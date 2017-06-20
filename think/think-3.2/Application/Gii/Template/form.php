<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{$action_name}<?php echo $title ?></title>
    <include file="Public:import" />
    <script>
        $(function () {
            $('#_form_').Validform({tiptype: _6, showAllError: true});
<?php if (array_key_exists('content', $fields)) { ?>
                KindEditor.ready(function (K) {
                    editor = K.create('#content', {
                        allowFileManager: true,
                        afterBlur: function () {
                            editor.sync();
                            $('#content').blur();
                        },
                        height: 400
                    })
                });
<?php } ?>
        });
    </script>
</head>

<body>
    <div class="mybreadcrumb">
        <ol class="breadcrumb">
            <li><a href="__MODULE__" target="_top"><i class="icon-home"></i>主页</a></li>
            <li><a href="__URL__/index"><?php echo $title ?>管理</a></li>
            <li class="active">{$action_name}<?php echo $title ?></li>
        </ol>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">{$action_name}<?php echo $title ?></div>
        <div class="panel-body">
            <form class="form-horizontal" action="__ACTION__" method="post" role="form" id="_form_">
                <input type="hidden" value="{$data.id}" name="id" />
                <?php foreach ($fields as $k => $v) { ?>
                    <?php
                    if ($k == 'id' or $k == 'time') {
                        continue;
                        ?>
                    <?php } else if ($k == 'status' || strpos($k, 'is_')) { ?>
                        <div class="form-group">
                            <label for="lastname" class="col-sm-1 control-label"><?php echo $v ?></label>
                            <div class="col-sm-3">
                                <input type="hidden" value="0" name="<?php echo $k ?>" />
                                <input type="checkbox" class="switch-checkbox" value="1" name="<?php echo $k ?>" <eq name="data.<?php echo $k ?>" value="1" >checked</eq> />
                            </div>                    
                        </div>
                    <?php } else if ($k == 'content') { ?>
                        <div class="form-group">
                            <label class="col-sm-1 control-label"><?php echo $v ?></label>
                            <div class="col-sm-6">
                                <textarea name="<?php echo $k ?>"  id="content" class="form-control" placeholder="请输入<?php echo $v ?>" datatype="*">{$data.<?php echo $k ?>}</textarea>
                            </div>
                        </div>
                    <?php } else if ($k == 'desc') { ?>
                        <div class="form-group">
                            <label class="col-sm-1 control-label"><?php echo $v ?></label>
                            <div class="col-sm-5">
                                <textarea name="<?php echo $k ?>" rows="3"  class="form-control" placeholder="请输入<?php echo $v ?>" datatype="*">{$data.<?php echo $k ?>}</textarea>
                            </div>
                        </div>                    
                    <?php } else if (false !== strpos($k, 'id')) { ?>
                        <div class="form-group">
                            <label class="col-sm-1 control-label"><?php echo $v ?></label>
                            <div class="col-sm-5">
                                <select class="form-control" name="<?php echo $k ?>" datatype="*">
                                    <option value="">请选择...</option>
                                    <volist name="<?php echo $k ?>" id="vo">
                                        <option value="{$key}" <eq name="data.<?php echo $k ?>" value="$key">selected</eq> >{$vo}</option>
                                    </volist>                            
                                </select>
                            </div>
                        </div>               
                        <?php
                    } else if ($k == 'photo') {
                        $has_photo = true
                        ?>
                        <div class="form-group">
                            <label class="col-sm-1 control-label"><?php echo $v ?></label>
                            <div class="col-sm-5">
                                <input type="hidden" value="{$data.photo}" id="thumb" name="photo"/>
                                <input type="file" class="form-control" id="file_upload" />                       
                                <div class="uploadify_image"><img src="{$data.photo}" id="image" style="max-height:100px;"/></div>
                            </div>
                        </div>                
                        <?php
                    } else if ($k == 'picture') {
                        $has_pic = true
                        ?>
                        <div class="form-group">
                            <label class="col-sm-1 control-label"><?php echo $v ?></label>
                            <div class="col-sm-5">                       
                                <input type="file" class="form-control" id="mute_file_upload" /> 
                                <div id="imgbox"><volist name="$data.picture" id="vo">
                                        <img src="{$vo}" height="80"/><input type="hidden" name="picture[]" value="{$vo}" />
                                    </volist>
                                </div>
                            </div>
                        </div>        
                    <?php } else { ?>                
                        <div class="form-group">
                            <label class="col-sm-1 control-label"><?php echo $v ?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="<?php echo $k ?>" value="{$data.<?php echo $k ?>}" datatype="*" placeholder="请输入<?php echo $v ?>">
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-10">
                        <button type="submit" class="btn btn-success">保存</button>
                        <button type="reset" class="btn btn-default">重置</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<include file="Public:footer" />
<?php if ($has_photo) { ?>
    <include file="Public:uploadfy" />
<?php }if ($has_pic) { ?>
    <include file="Public:muteupfy" />
<?php } ?>
</body>
</html>
