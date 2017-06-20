<?php

namespace Home\Controller;

use \Common\Controller\HomeController;

class CommonController extends HomeController {

    function _initialize() {
        parent::_initialize();
    }

    /**
     * 获取对应权限
     * @param type $data_auth  数据所属用户组
     */
    protected function _auth($data_auth, $url = '', $gonum = null) {
        //所以人
        if ($data_auth == 0) { //所以人
            return true;
        } elseif ($data_auth == 1) {  //只要是登录的会员就可以
            if ($this->getUser()) {
                return true;
            } else {
                $this->goLogin($url, $gonum);
            }
        } else { //其他对应会员用户
            if ($this->getUser('gid') == $data_auth) {
                return true;
            } else {
                $this->error("你没有访问此页面的权限！", $gonum);
            }
        }
    }

    //带地址的 跳转到登录地址
    protected function goLogin($url, $gonum = -2, $tit = "请先登录") {
        $login_url = '/login/index/url/' . base64_encode($url);
        if ($gonum) {
            $login_url.='/gonum/' . $gonum;
        }
        $this->error($tit, $login_url);
    }

    //发送短信验证码
    protected function _send_sms($mobile = null, $ajax = false) {
        $mobile = $mobile ? $mobile : I('mobile');

        //判断手机号码格式
        if ($mobile == '' || !preg_match('/^1[3-9]\d{9}$/', $mobile)) {
            $this->error('手机号码为空或不正确', null, $ajax);
        }

        $m = D('SmsRecord');
        //同一手机号 1分钟内只能发送一次
        $one_min = time() - 60;
        if ($m->where("mobile=$mobile AND send_time > $one_min")->find()) {
            $this->error('您发送的太频繁了，请稍后再试', null, $ajax);
        }
        //同一IP一天之内只能发送20次
        $ip = get_client_ip();
        $day_time = time() - 24 * 60 * 60;
        if (D('SmsRecord')->where("ip='$ip' AND send_time > $day_time")->count() > 20) {
            $this->error('您发送了太多短信了，请明天再试', null, $ajax);
        }

        //生成验证码
        $code = rand(100000, 999999);
        //短信内容必须按照 接口中的模板来。不得更改一个字或标点符号  奇葩短信接口啊
        $content = '您的验证码是：' . $code . '。请不要把验证码泄露给其他人。如非本人操作，可不用理会！';
        $recode = sms($mobile, $content);

        //$recode = array('code' => 100); //调试使用
        //发送成功保存数据到session中
        if ($recode['code'] == 100) {
            $_SESSION['sms']['code'] = $code; //验证码
            $_SESSION['sms']['time'] = time(); //当前时间
            $_SESSION['sms']['mobile'] = $mobile; //获取的手机号码
            //保存短信数据到数据库中 
            $m->add(array('ip' => $ip, 'mobile' => $mobile, 'send_time' => time(), 'content' => $content));
            $this->success('验证码获取成功', null, $ajax);
        } else {
            $this->error($recode['msg'], null, $ajax);
        }
    }

    //验证短信验证码
    protected function _chekc_sms($code, $mobile, $unlink = false) {
        if (!$code || !$mobile) {
            return array('status' => 'n', 'info' => '验证码或手机号为空');
        }

        //每次验证session时间过期  5分钟过期
        if ($_SESSION['sms']['time'] <= time() - 300) {
            session('sms', null);
        }


        //判断session中的验证码
        if ($_SESSION['sms']['code'] == $code && $mobile == $_SESSION['sms']['mobile']) {
            //if ($unlink) {
            //为了使 短信可以使用多次。不进行删除
            //unset($_SESSION['sms']); //验证成功后删除 session
            // }
            return array('status' => 'y', 'info' => "验证码正确");
        } else {
            return array('status' => 'n', 'info' => "验证码错误");
        }
    }

}
