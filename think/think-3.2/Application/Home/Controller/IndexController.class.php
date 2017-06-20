<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends CommonController {

    public function index() {
        //banner图片
        $this->assign('ad_banner', D('Ad')->getAd(1));
        //正在直播
        $zhibo_ad = D('Ad')->getAd(2);
        $time = time();

        $zhibo = D('Live')->getList(array(
            'where' => "endtime>$time",
            'rows' => 4,
            'order' => 'time'
                )
        );
        //精品点播
        $recommend['dianbo'] = D('Vedio')->where('recommend=3')->order('id desc')->find();
        //推荐的ID
        $recid = $recommend['dianbo']['id'] ? $recommend['dianbo']['id'] : 0; //如果没有推荐 就会出现 找不到数据

        $dianbo = D('Vedio')->getList(array('where' => "id <> $recid", 'rows' => 4));

        //名师观点      
        $recommend['guandian'] = D('Article')->where('recommend=3')->order('id desc')->find();
        //推荐ID
        $recid = $recommend['guandian']['id'] ? $recommend['guandian']['id'] : 0; //如果没有推荐 就会出现 找不到数据

        $guandian = D('Article')->getList(array(
            'where' => "id <> $recid AND cid=10",
            'rows' => 4,
                )
        );

        //获取定义的项目
        $t_xm = array(2 => '鹰眼项目', 3 => '速赢项目', 4 => '睿赢项目', 5 => '稳赢项目');
        //获取对应项目的观点
        foreach ($t_xm as $k => $v) {
            //查找对应的
            $tmp_art = D('Article')->where("cid=10 AND auth=$k")->order('id desc')->limit(6)->select();
            //对应项目 统计数据
            $tmp_shuju = D('Xmconfig')->getData($k);
            $xiangmu[] = array(
                'name' => $v,
                'art' => $tmp_art,
                'shuju' => $tmp_shuju
            );
        }

        //卓汇动态
        $dongtai = D('Article')->where("cid=4")->order('id desc')->limit(3)->select();

        //资金托管
        $ltg = D('Link')->getLink(1);
        //合作伙伴
        $lhb = D('Link')->getLink(2);

        $this->assign('zhibo', $zhibo)
                ->assign('zhibo_ad', $zhibo_ad)
                ->assign('dianbo', $dianbo)
                ->assign('recommend', $recommend)
                ->assign('xiangmu', $xiangmu)
                ->assign('dongtai', $dongtai)
                ->assign('ltg', $ltg)
                ->assign('lhb', $lhb)
                ->assign('guandian', $guandian);

        $this->display();
    }

    //获取行情数据 采集其他网站数据
    function hangqing() {
        $type = I('type');
        switch ($type) {
            case 1:
                $content = file_get_contents('http://www.kxt.com/chart?interval=1d&type=candlestick&rows=45&code=conc');
                //去除文字
                $content = str_replace('<style>', "<style>#website{display:none}", $content);
                break;
            case 2:
                $content = file_get_contents('http://www.kxt.com/chart?interval=1d&type=candlestick&rows=45&code=diniw');
                break;
            case 3:
                $content = file_get_contents('http://180.166.148.176:16919/hqweb/images/OIL1000KLine.png');
                header("Content-Type:image/png");
                echo $content;
                exit;
            default :
                $content = "";
                break;
        }
        if ($content) {
            //相对路径转换为绝对路径
            $content = preg_replace('/\/skin/', 'http://www.kxt.com/skin', $content);
            $this->show($content);
        }
    }

    //测试使用方法
    function test() {
        $m = D('Article');
        $m->where(array('cid' => 1, 'status' => 'no'))->find();
        var_dump($m->_sql());
        $m->where(array('cid' => 1))->find();
        var_dump($m->_sql());
        $m->where(array('cid' => 1))->count();
        var_dump($m->_sql());
        $m->where("id = 5")->save(array('title' => 'aaa'));
        echo $m->_sql();
    }

    //更新项目交易数据
    function update_xm_data() {
        $user = 'zhjr_xm_user';
        $pwd = 'zhjr_xm_pwd';
        $akey = I('akey');
        if ($akey == md5($user . $pwd)) {
            D('Xmconfig')->updateData();
        } else {
            E('更新错误');
        }
    }

}
