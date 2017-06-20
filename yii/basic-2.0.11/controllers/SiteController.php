<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

/**
 * AppID  wxc889d87e3306c2fd
  AppSecret  5cfe1bb2721447261eba8a0a86e74a6d
 */
define('APPID', 'wxca0f13a54591aa37');
define('APPSECRET', '873f251675820fccb2521f8f63a94722');

class SiteController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 4,
                'minLength' => 4,
                'height' => 32,
                'offset' => 10,
            ],
        ];
    }

    function actionMain() {
        //登录到长江
        $this->redirect('http://w217.cjmex.cn/vexchange/main');
    }

    function actionTest() {
        $uri = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' .
                APPID . '&redirect_uri=http://test.zhjr9090.com/site/openid&response_type=code&scope=snsapi_base&state=123#wechat_redirect';
        $this->redirect($uri, 301);
    }

    function actionOpenid() {
        setcookie('openid', $_GET['code']);
        $this->redirect('main', 301);
    }

    public function actionIndex() {
        //return $this->render('index');
    }

    public function actionQrcode() {
        return $this->render('qrcode');
    }

    public function actionRule() {
        //获取会员信息
        $url = 'http://w217.cjmex.cn/vexchange/individual';
        //初始化curl
        $curl = curl_init($url);
        //curl超时 30s
        curl_setopt($curl, CURLOPT_TIMEOUT, '30');
        //user-agent头
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:14.0) Gecko/20120722 Firefox/14.0.1");
        //返回文件流
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        //打开头文件数据流输出
        //curl_setopt($curl, CURLOPT_HEADER, 1);
        $string = curl_exec($curl);
        var_dump($string);
        // return $this->render('rule');
    }

    public function actionShare() {
        return $this->render('share');
    }

    //获取菜单
    function actionMenu() {
        $uri = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token=' . $this->getToken();
        echo file_get_contents($uri);
    }

    //创建菜单
    public function actionCreateMenu() {
        $uri = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $this->getToken();
        // 参数数组
        $data = '{
            "button":[
            {
                 "type":"view",
                 "name":"测试",
                 "url":"http://test.zhjr9090.com/site/test"
             },
             {
                  "type":"click",
                  "name":"简介",
                  "key":"introduct"
             },
             {
                  "name":"菜单",
                  "sub_button":[
                   {
                      "type":"view",
                      "name":"分享",
                      "url":"http://test.zhjr9090.com/site/share"
                   },
                   {
                      "type":"view",
                      "name":"规则",
                      "url":"http://test.zhjr9090.com/site/rule"
                   }]
              }]
       }';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)'); // 模拟用户使用的浏览器  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_exec($ch);
        curl_close($ch);
    }

    //获取token

    function actionToken() {
        echo $this->getToken();
    }

    protected function getToken() {
        $session = Yii::$app->session;
        if (!($session['token'] && $session['token']['time'] > time())) {
            $token = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxca0f13a54591aa37&secret=873f251675820fccb2521f8f63a94722');
            $token = json_decode($token);
            $time = time() + $token->expires_in;
            $session['token'] = [
                'access_token' => $token->access_token,
                'time' => $time,
            ];
        }
        return $session['token']['access_token'];
    }

    function actionMsg() {
        if (!isset($_GET['echostr'])) {
            echo '';
        } else {
            $this->_checkSignature();
        }
    }

    private function _checkSignature() {
        $re = Yii::$app->request;
        $token = 'weixin';
        $signature = $re->get('signature');
        $tmpArr = array($token, $re->get('timestamp'), $re->get('nonce'));
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            exit($_GET['echostr']);
        } else {
            return false;
        }
    }

    protected function post($uri, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)'); // 模拟用户使用的浏览器  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_exec($ch);
        curl_close($ch);
    }

}
