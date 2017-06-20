<?php

namespace Common\Model;

use Think\Model;

/**
 * 推荐位 模型，专保存推荐位的。
 */
class RecommendModel extends CommonModel {

    public $_fields = array(
        1 => '热门',
        2 => '置顶',
        3 => '图文【图片】'
    );

    //是否带有此推荐
    public function has($haystack, $needle, $output = null, $sep = ',') {
        if (false !== strpos($sep . $haystack . $sep, $sep . $needle . $sep)) {
            if ($output) {
                return $output;
            } else {
                return true;
            }
        } else {
            return '';
        }
    }

    //显示出具备的所有的推荐
    function arrHas($haystack, $output = null, $sep = ',') {
        $out = '';
        foreach ($this->_fields as $k => $v) {
            if (false !== strpos($sep . $haystack . $sep, $sep . $k . $sep)) {
                if ($output)
                    $out.=$output;
                else
                    $out.=$v . '&nbsp;&nbsp;';
            }
        }
        return $out;
    }

}
