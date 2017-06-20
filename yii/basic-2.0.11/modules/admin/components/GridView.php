<?php

namespace app\modules\admin\components;

class GridView extends \yii\grid\GridView {

    public $layout = '{items}<div class="page">{pager}{summary}</div>';
    public $summary = '<div class="summary">第<b>{page}</b>页，共<b>{totalCount}</b>条数据，共<b>{pageCount}</b>页</div>';
    public $template="{delete}";

}
