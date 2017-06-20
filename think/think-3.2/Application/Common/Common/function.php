<?php

//字符串 截取
function strcut($str, $len, $encoding = "UTF-8") {
    $tmp = mb_substr($str, 0, $len, $encoding);
    if (mb_strlen($str, $encoding) > $len)
        $tmp.='...';
    return $tmp;
}

/**
 * 显示目录下的所有文件
 * dir 目录
 * Order 排序方式 0顺序 1倒序
 */
function ShowDir($dir, $Order = 0) {
    if (!is_dir($dir))
        throw new Exception($dir . '不是有效的目录');
    $FilePath = opendir($dir);
    if (!$FilePath) {
        throw new Exception('打开文件夹失败');
    }
    $fileArr = '';
    while ($filename = readdir($FilePath)) {
        if ($filename != '.' && $filename != '..')     //如果是文件 保存 	
            $fileArr[] = $filename;
    }
    if (is_array($fileArr)) {
        $Order == 0 ? sort($fileArr) : rsort($fileArr);
        return $fileArr;
    } else
        return false;
}

/**
 * 文件下载
 */
function Download($filename, $realname = '') {
    if (!file_exists($filename)) {
        //header("Content-type: text/html; charset=utf-8");
        //echo 'File not found!';
        header('index.php/Home/Index/download.html');
        //exit;
    } else {
        if ($realname == '')
            $realname = basename($filename);                                         //设置中文名字
        $realname = iconv("UTF-8", "GBK", $realname);
        if (!strpos($realname, '.'))
            $realname = $realname . '.' . pathinfo($filename, PATHINFO_EXTENSION);   //判断 是否有扩展名
        $file = fopen($filename, "r");
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length: " . filesize($filename));
        Header("Content-Disposition: attachment; filename=" . $realname);
        echo fread($file, filesize($filename));
        fclose($file);
    }
}

/*
 * 判断多维空数组
 * 为空 返回 false
 * 不为空 返回 true
 */

function array_is_null($arr = null) {
    if (is_array($arr)) {
        foreach ($arr as $k => $v) {
            if ($v && !is_array($v)) {
                return false;
            }
            $t = self::array_is_null($v);
            if (!$t) {
                return false;
            }
        }
        return true;
    } elseif (!$arr) {
        return true;
    } else {
        return false;
    }
}

/**
 * 保存远程数据 到本地
 */
function img2local($str) {
    preg_match_all("/<img.*?src=[\'|\"](http:\/\/.*?(jpg|png|bmp|gif))[\'|\"].*?[\/]?>/i", $str, $match); //取得 远程图片路径
    if (!is_array($match[1]))
        return null;
    //创建当月为的路径
    $dir = 'uploads/userfiles/images/' . date('m') . '/';
    @mkdir($dir);
    foreach ($match[1] as $k => $v) {
        //获取扩展名  并 保存文件 名
        $ext = pathinfo($v, PATHINFO_EXTENSION);
        $filename = $dir . time() . $k . '.' . $ext;
        if ($fileCont = @file_get_contents($v)) {
            $handle = fopen($filename, 'w');
            if (fwrite($handle, $fileCont)) {  //写入成功  替换原有数据
                $str = str_replace($v, $filename, $str);
            }
        }
    }
    return $str;
}

/**
 *  返回 内容中的第一张图片
 */
function getFirstImg($str) {
    preg_match("/<img.*?src=[\'|\"](.*?(jpg|png|bmp|gif))[\'|\"].*?[\/]?>/i", $str, $match);
    return isset($match[1]) ? $match[1] : null;
}

/**
 * 相似度 函数
 * 默认 10条相识数据
 */
function similar($title, $arr_title, $limit = 5) {
    foreach ($arr_title as $k => $v) {
        similar_text($v['title'], $title, $percent[$k]['sort']);
        $percent[$k]['data'] = $v;
    }
    //数组排序  按  相似度 降序排
    array_multisort($percent, SORT_DESC);
    for ($i = 1; $i <= $limit; $i++) {    //从1 开始 去除 第一个最相关的 自己;
        $data[] = $percent[$i]['data'];
    }
    return $data;
}

//加密
function encrypt_encode($txt, $key) {
    srand((double) microtime() * 1000000);
    $rand = rand(1, 10000);
    $encrypt_key = md5($rand);
    $ctr = 0;
    $tmp = '';
    for ($i = 0; $i < strlen($txt); $i++) {
        $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $encrypt_key[$ctr] . ($txt[$i] ^ $encrypt_key[$ctr++]);
    }
    $tmp = encrypt_key($tmp, $key);
    return base64_encode($tmp);
}

//解密
function encrypt_decode($txt, $key) {
    $txt = base64_decode($txt);
    $txt = encrypt_key($txt, $key);
    $tmp = '';
    for ($i = 0; $i < strlen($txt); $i++) {
        $md5 = $txt[$i];
        $tmp .= $txt[++$i] ^ $md5;
    }
    return $tmp;
}

//生成密匙
function encrypt_key($txt, $encrypt_key) {
    $encrypt_key = md5($encrypt_key);
    $ctr = 0;
    $tmp = '';
    for ($i = 0; $i < strlen($txt); $i++) {
        $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
    }
    return $tmp;
}

/*
 * 删除文件夹 包括  子文件夹
 * @path  文件夹路径
 * @is_del_dir  是否删除当前文件夹
 */

function delete_dir($path, $is_del_dir = false) {
    $dir = opendir($path);
    if (!$dir) {
        return array('err' => 1, 'errmsg' => '不是有效的文件夹地址');
    }
    while (false !== ($file = readdir($dir))) {
        if (($file != "." && $file != "..") && $file != "") {
            $tmpFile = "$path/$file";
            if (is_dir($tmpFile)) {  //如果是文件夹 递归进入
                delete_dir($tmpFile);
                @rmdir($tmpFile); //删除文件夹
            } else {
                @unlink($tmpFile);
            }
        }
    }
    if ($is_del_dir == true)
        @rmdir($path); //删除文件夹
    return array('err' => 0, 'errmsg' => '删除成功');
}

/**
 * @param unknown_type $str
 * @return 取得汉字的首字母
 */
function getFirstChar($str) {
    $fchar = $str[0];
    //判断是否为字符串
    if (ord($fchar) >= ord("A") && ord($fchar) <= ord("z"))
        return strtoupper($fchar);
    $str = iconv("UTF-8", "gb2312", $str);
    $asc = ord($str[0]) * 256 + ord($str[1]) - 65536;
    if ($asc >= -20319 and $asc <= -20284)
        return "A";
    if ($asc >= -20283 and $asc <= -19776)
        return "B";
    if ($asc >= -19775 and $asc <= -19219)
        return "C";
    if ($asc >= -19218 and $asc <= -18711)
        return "D";
    if ($asc >= -18710 and $asc <= -18527)
        return "E";
    if ($asc >= -18526 and $asc <= -18240)
        return "F";
    if ($asc >= -18239 and $asc <= -17923)
        return "G";
    if ($asc >= -17922 and $asc <= -17418)
        return "H";
    if ($asc >= -17417 and $asc <= -16475)
        return "I";
    if ($asc >= -16474 and $asc <= -16213)
        return "J";
    if ($asc >= -16212 and $asc <= -15641)
        return "K";
    if ($asc >= -15640 and $asc <= -15166)
        return "L";
    if ($asc >= -15165 and $asc <= -14923)
        return "M";
    if ($asc >= -14922 and $asc <= -14915)
        return "N";
    if ($asc >= -14914 and $asc <= -14631)
        return "P";
    if ($asc >= -14630 and $asc <= -14150)
        return "Q";
    if ($asc >= -14149 and $asc <= -14091)
        return "R";
    if ($asc >= -14090 and $asc <= -13319)
        return "S";
    if ($asc >= -13318 and $asc <= -12839)
        return "T";
    if ($asc >= -12838 and $asc <= -12557)
        return "W";
    if ($asc >= -12556 and $asc <= -11848)
        return "X";
    if ($asc >= -11847 and $asc <= -11056)
        return "Y";
    if ($asc >= -11055 and $asc <= -10247)
        return "Z";
    return null;
}

/**
 * timestramp格式化时间 
 * @param type $timestramp
 * @param type $format
 * @return type
 */
function pdate($timestramp, $format = "Y-m-d") {
    return date($format, strtotime($timestramp));
}

/**
 * 上传图片文件
 */
function uploadImg() {
    $upload = new \Think\Upload(); // 实例化上传类
    $upload->maxSize = 10485760; // 设置附件上传大小
    $upload->saveExt = 'jpg'; //文件保存后缀，空则使用原后缀
    $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
    $path = 'Uploads/';

    if (!$info = $upload->uploadOne($_FILES['Filedata'], $path)) {// 上传错误提示错误信息
        $this->error($upload->getError());
    } else {// 上传成功 获取上传文件信息
        $newFile = $path . $info['savepath'] . $info['savename'];

        $width = isset($_POST['width']) ? $_POST['width'] : 300;
        $height = isset($_POST['height']) ? $_POST['height'] : 300;

        if ($_POST['type']) {
            $thumbs = new \Think\Image();
            $thumbs->open($newFile);
            $url = './Uploads/default/water.png';
        }

        //type 判断类型  1 有水印  2有大小图   3有水印又有大小图  默认无水印无大小图
        switch ($_POST['type']) {
            case 1:
                $thumbs->thumb($width, $height)->water($url, \Think\Image::IMAGE_WATER_SOUTHEAST, 50)->save($newFile);
                break;
            case 2:
                $thumbs->thumb(1000, 1000)->save($newFile . '.big.jpg');
                $thumbs->thumb($width, $height)->save($newFile);
                break;
            case 3:
                $thumbs->thumb(1000, 1000)->water($url, \Think\Image::IMAGE_WATER_SOUTHEAST, 50)->save($newFile . '.big.jpg');
                $thumbs->thumb($width, $height)->water($url, \Think\Image::IMAGE_WATER_SOUTHEAST, 50)->save($newFile);
                break;
            case 4:
                //只改变尺寸
                $thumbs->thumb($width, $height)->save($newFile);
                break;
            default :
                //不处理 使用原图大小和尺寸
                break;
        }
        //输出
        return __ROOT__ . '/' . $newFile;
    }
}

/**
 * 短信发送
 * @param type $mobile 手机号码
 * @param type $content 发送内容
 */
function sms($mobile, $content) {
    $code = array(
        100 => '发送成功',
        101 => '验证失败',
        102 => '手机号码格式不正确',
        103 => '会员级别不够',
        104 => '内容未审核',
        105 => '内容过多',
        106 => '账户余额不足',
        107 => 'Ip受限',
        108 => '手机号码发送太频繁，请换号或隔天再发',
        109 => '帐号被锁定',
        110 => '发送通道不正确',
        111 => '当前时间段禁止短信发送',
        120 => '系统升级',
    );
    $user = C('SMS_USER');
    $pwd = C('SMS_PWD');
    $url = "http://sms.106jiekou.com/utf8/sms.aspx?account=$user&password=$pwd&mobile=$mobile&content=$content";
    $r_code = file_get_contents($url);
    $data['code'] = $r_code;
    $data['msg'] = $code[$r_code];
    return $data;
}

/**
 * 去除HTML标签
 */
function strip_tags_ext($str, $len = 0) {
    $str = trim(strip_tags($str));
    $str = preg_replace(array('/&nbsp;|[\t\n\s]|　/'), '', $str);
    if (!$len)
        $len = 120;
    return mb_substr($str, 0, $len, 'UTF-8');
}

/**
 * 替换手机号码 中间4位数为星号
 */
function mobile_star($str) {
    return preg_replace('/(\d{3})\d{4}/', '$1****', $str);
}

/**
 * 转化万或千万 亿为单位的数
 */
function conv_unit($num) {
    if ($num > 10000000) {
        //返回千万
        return round(($num / 100000000), 2) . '亿';
    } else {
        //返回万
        return floor(($num / 10000)) . '万';
    }
}
