<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title ?>管理</title>
    <include file="Public:import" />
</head>

<body>
    <div class="mybreadcrumb">
        <ol class="breadcrumb">
            <li><a href="__MODULE__" target="_top"><i class="icon-home"></i>主页</a></li>
            <li><a href="__URL__/index"><?php echo $title ?>管理</a></li>
            <li class="active">列表</li>
        </ol>
    </div>
    <div class="panel panel-default">    
        <div class="panel-body">
            <div class="box_header">
                <div class="btn-group pull-left"> <a href="__URL__/add" class="btn btn-success"><i class="icon-plus"></i>添加</a>
                    <button type="button" to="__URL__/remove" class="btn btn-default" id="removeAll"><i class="icon-remove"></i>删除</button>
                    <a href="__URL__/toExcel" onclick="return msg.confirm('确定要导出到Excel？', this)" class="btn btn-default"><i class="icon-signout"></i>导出到Excel</a>
                    <button type="button" data-toggle="modal" data-target="#modal_upload_excel" class="btn btn-default"><i class="icon-signin"></i>从Excel导入</button>
                    <button type="button" to="__URL__/resort" class="btn btn-default" id="resort"><i class="icon-sort"></i>更新排序</button>
                </div>
                <div class="pull-right">
                    <form class="form-inline" role="form" action="__ACTION__" method="get" id="search_form">
                        <select class="form-control" name="stype" id="search_stype">
                            <?php foreach ($fields as $key => $v) { ?>
                                <option value="<?php echo $key ?>" <if condition="$_REQUEST['stype']=='<?php echo $key ?>'"> selected </if> ><?php echo $v ?></option>
                            <?php } ?>                            
                        </select>
                        <?php foreach ($fields as $key => $v) { ?>
                            <?php if (strpos($key, 'id')) { ?>
                                <div class="form-group" id='<?php echo $key ?>' style="display: none;">
                                    <select class="form-control" name="<?php echo $key ?>" style="width: 150px;">
                                        <volist name="<?php echo $key ?>" id="vo">
                                            <option value="{$key}" <eq name="Think.Request.<?php echo $key ?>" value="$key">selected</eq> >{$vo}</option>
                                        </volist>
                                    </select>
                                </div>                                                       <?php } ?>
                        <?php } ?>
                        <div class="form-group">
                            <label class="sr-only" for="name">搜索内容</label>
                            <input type="text" class="form-control" name="skey" value="{$Think.Request.skey}" placeholder="请输入搜索内容...">
                        </div>
                        <button type="submit" class="btn btn-default">搜索</button>
                    </form>
                </div>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="30"><input type="checkbox" id="sel-all"/></th>
                        <?php foreach ($fields as $v) { ?>
                            <th width=""><?php echo $v ?></th>
                        <?php } ?>
                        <th width="183">操作</th>
                    </tr>
                </thead>
                <tbody>
                <volist name="list" id="vo">
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="{$vo.id}" class="checkbox-sel"/></td>
                        <?php foreach ($fields as $k => $v) { ?>
                            <?php if ($k == 'sort') { ?>
                                <td><input type="text" value="{$vo.<?php echo $k ?>}" ids="{$vo.id}" class="t_sort form-control text-center"/></td>                           
                            <?php } elseif ($k == 'photo') { ?>
                                <td><img src="{$vo.<?php echo $k ?>}" height="80"/></td>
                            <?php } elseif (strpos($k, 'id')) { ?>
                                <td>{$<?php echo $k ?>[$vo['<?php echo $k ?>']]}</td>
                            <?php } else { ?>
                                <td>{$vo.<?php echo $k ?>}</td>
                                <?php
                            }
                        }
                        ?>
                        <td>
                            <a href="__URL__/view/id/{$vo.id}" class="btn btn-success btn-xs"><i class="icon-external-link"></i>查看</a>
                            <a href="__URL__/edit/id/{$vo.id}" class="btn btn-info btn-xs"><i class="icon-edit"></i>编辑</a>
                            <a href="__URL__/remove/id/{$vo.id}" onclick="return msg.confirm('确定删除?', this);" class="btn btn-danger btn-xs"><i class="icon-remove"></i>删除</a>
                        </td>
                    </tr>
                </volist>                    
                </tbody>
            </table>
            <div class="pager">{$show}</div>
        </div>
    </div>
<include file="Public:footer" />
</body>
</html>
