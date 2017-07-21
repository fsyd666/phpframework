<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\manage\components;

class UrlManager extends \yii\web\UrlManager {

    //后台不使用伪静态
    public function parseRequest($request) {
        $pathInfo = $request->getPathInfo();
        if (stripos($pathInfo, 'manage') === 0) {
            $this->suffix = '';
        }
        return parent::parseRequest($request);
    }

}
