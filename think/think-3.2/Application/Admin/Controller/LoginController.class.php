<?php

namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller {

    private $user_key = 'Zh%Jr#123';

    public function index() {
        //如果有cookie值
        if ($ckdata = cookie(md5($this->user_key))) {
            //解析cookie内容获取用户ID
            $ckdata = encrypt_decode($ckdata, $this->user_key);
            $uid = str_replace($this->user_key, '', $ckdata);
            $user = D('Admin')->find($uid);
            //有用户数据保存起来
            if ($user) {
                $this->save_user($user);
            }
        }

        if ($_SESSION['admin']['id']) {
            $this->redirect('Index/index');
        }
        $this->display();
    }

    public function resetpwd() {
        $this->display();
    }

    function chkuser() {
        $verify = new \Think\Verify();
        if (!$verify->check($_POST['captcha'])) {
            $this->error('验证码错误');
        }
        //用户判断
        if (false != $user = M('admin')->where("user='{$_POST['username']}'")->find()) {
            if ($user['pwd'] == md5($_POST['password'])) {
                $this->save_user($user);

                //如果设置了记住密码 默认保存1个星期
                if (I('remember')) {
                    $uinfo = $this->user_key . $user['id'];
                    $authkey = encrypt_encode($uinfo, $this->user_key);
                    $cookie_key = md5($this->user_key);
                    cookie($cookie_key, $authkey, 3600 * 24 * 7);
                }
                $this->redirect("Index/index");
            }
        }
        $this->error('用户名或密码错误');
    }

    //验证码
    function verify() {
        $Verify = new \Think\Verify(array('useCurve' => false));
        $Verify->entry();
    }

    //退出登录
    function logout() {
        session_unset(); //删除内存session
        session_destroy(); //删除session文件
        //删除cookie
        cookie(md5($this->user_key), null);
        $this->redirect('index');
    }

    //保存用户信息
    private function save_user($data) {
        $_SESSION['admin']['id'] = $data['id'];
        $_SESSION['admin']['nickname'] = $data['nickname'];

        //更新登录时间和IP
        $save['id'] = $data['id'];
        $save['last_date'] = date('Y-m-d H:i:s');
        $save['last_ip'] = get_client_ip();
        M('admin')->save($save);

        //保存菜单信息到 session中
    }

    /**
     * 上传图片
     */
    function uploadImg() {
        exit(uploadImg());
    }

}
