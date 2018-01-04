<?php

namespace Topxia\Component\MediaParser\AdvertParser;

use Symfony\Component\Serializer\Exception\RuntimeException;

//优酷点播 
class YoukuMedia extends AbstractAdvertParser {

    protected static $tmpArr = array(19, 1, 4, 7, 30, 14, 28, 8, 24, 17, 6, 35, 34, 16, 9, 10, 13, 22, 32, 29, 31, 21, 18, 3, 2, 23, 25, 27, 11, 20, 5, 15, 12, 0, 33, 26);

    //解析出URL中的ID编码
    public function getMediaInfo($url) {
        if (preg_match('/id_(\w+)==/', $url, $matchs)) {//id_XMTc4MTQ0MTU2NA==.html
            return $matchs[1];
        } elseif (preg_match('/\/sid\/(.*?)\/v\.swf/s', $url, $matchs)) {  //http://player.youku.com/player.php/sid/XMTg0MjI4ODQxNg==/v.swf
            return $matchs[1];
        }
        throw new RuntimeException('url 地址错误');
    }

    public function getMediaUrl($url) {
        $urlKey = $this->getMediaInfo($url);
        $tmpCharSet = mb_internal_encoding();

		//很重要   很多是这个原因导致 charCodeAt解码不一致问题。
        mb_internal_encoding('ISO-8859-1');

        $jsonData = $this->getJson($urlKey);
        if ($jsonData['data']['error']) {
            throw new RuntimeException('获取 Json 错误，' . $jsonData['data']['error']['note']);
        }

        foreach ($jsonData['data']['stream'] as $v) {
            if ($v['stream_type'] == '3gphd') {
                $fileid = $v['stream_fileid'];
                $ts = $v['milliseconds_video'] / 1000;
                $key = $v['segs'][0]['key'];
                break;
            }
        }

        if (!$fileid || !$ts) {
            throw new RuntimeException("fileId:$fileid 或者 ts:$ts 错误");
        }

        list($sid, $token) = $this->getSidToken($jsonData['data']['security']['encrypt_string']);

        if (!$sid || !$token) {
            throw new RuntimeException('sid 或token 没有找到!');
        }

        $ep = $this->getEp($sid, $fileid, $token);
        $oip = $jsonData['data']['security']['ip'];

        $url = '/player/getFlvPath/sid/' . $sid . '_00';
        $url.='/st/mp4/fileid/' . $fileid;
        $url.='?K=' . $key;
        $url.='&hd=1&myp=0&ts=' . $ts;
        $url.='&ypp=0&ep=' . $ep;
        $url.='&ctype=12&ev=1&token=' . $token . '&oip=' . $oip;

        mb_internal_encoding($tmpCharSet);

        return "http://k.youku.com" . $url;
    }

    public function getMobileMediaUrl($urlKey) {
        return $this->getMediaUrl($urlKey);
    }

    protected function getJson($urlKey) {
        //获取优酷client_id;
        $youkuUrl = 'http://player.youku.com/embed/' . $urlKey;
        $result = $this->curlGet($youkuUrl);
        preg_match('/client_id\s*=\s*\"(\w+)\"/', $result, $matchs);
        if (!$matchs[1]) {
            throw new RuntimeException('获取client_id错误');
        }
        $client_id = $matchs[1];

        $url = 'https://api.youku.com/players/custom.json?client_id=' . $client_id;
        $url.='&embsig=undefined&refer=' . urlencode($youkuUrl);
        $url.='&type=h5&video_id=' . $urlKey;


        $custom = $this->curlGet($url);
        $custom = json_decode($custom, true);
        $url = 'http://play.youku.com/play/get.json?vid=' . $urlKey . '&ct=12&r=' . urlencode($custom['stealsign']);

        $json = $this->curlGet($url);
        if (!$json) {
            throw new RuntimeException('获取 Json;没有取到数据');
        }

        return json_decode($json, true);
    }

    protected function curlGet($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent:Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.76 Mobile Safari/537.36'));

        $respone = curl_exec($ch);
        if (curl_errno($ch) != 0) {
            throw new RuntimeException(curl_error($ch));
        }
        curl_close($ch);
        return $respone;
    }

    /**
     * 
     * @return type array(sid  token)
     */
    protected function getSidToken($encrypt_string) {
        $tmpArr = self::$tmpArr;
        $h = $this->N($this->O('b4eto0b4', $tmpArr), $this->Ea($encrypt_string));
        $arrH = explode("_", $h);
        if (2 > count($arrH)) {
            return false;
        }
        $sid = $arrH[0];
        $token = $arrH[1];

        return array($sid, $token);
    }

    protected function getEp($sid, $fileid, $token) {
        $tmpArr = self::$tmpArr;
        $str = $this->O("boa4poz1", $tmpArr);
        $str = $this->N($str, $sid . '_' . $fileid . '_' . $token);
        $str = $this->L($str);
        return urlencode($str);
    }

    protected function L($b) {
        if (!$b)
            return "";
        $e = $c = $d = $m = $f = $g = '';
        $d = mb_strlen($b);
        $c = 0;
        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
        for ($e = ""; $c < $d;) {
            $m = $this->charCodeAt($b, $c++) & 255;
            if ($c == $d) {
                $e .= $str[$m >> 2];
                $e .= $str[($m & 3) << 4];
                $e .= "==";
                break;
            }
            $f = $this->charCodeAt($b, $c++);
            if ($c == $d) {
                $e .= $str[$m >> 2];
                $e .= $str[($m & 3) << 4 | ($f & 240) >> 4];
                $e .= $str[($f & 15) << 2];
                $e .= "=";
                break;
            }
            $g = $this->charCodeAt($b, $c++);
            $e .= $str[$m >> 2];
            $e .= $str[($m & 3) << 4 | ($f & 240) >> 4];
            $e .= $str[($f & 15) << 2 | ($g & 192) >> 6];
            $e .= $str[$g & 63];
        }
        return $e;
    }

    protected function Ea($b) {
        if (!$b)
            return "";
        $e = $c = $h = $d = $f = '';
        $g = array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1, -1, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1, -1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1);
        $d = mb_strlen($b);
        $h = 0;
        for ($f = ""; $h < $d;) {
            do
                $e = $g[$this->charCodeAt($b, $h++) & 255]; while ($h < $d && -1 == $e);
            if (-1 == $e)
                break;
            do
                $c = $g[$this->charCodeAt($b, $h++) & 255];
            while ($h < $d && -1 == $c);
            if (-1 == $c)
                break;
            $f .= $this->fromCharCode($e << 2 | ($c & 48) >> 4);
            do {
                $e = $this->charCodeAt($b, $h++) & 255;
                if (61 == $e)
                    return $f;
                $e = $g[$e];
            } while ($h < $d && -1 == $e);
            if (-1 == $e)
                break;
            $f .= $this->fromCharCode(($c & 15) << 4 | ($e & 60) >> 2);
            do {
                $c = $this->charCodeAt($b, $h++) & 255;
                if (61 == $c)
                    return $f;
                $c = $g[$c];
            } while ($h < $d && -1 == $c);
            if (-1 == $c)
                break;
            $f .= $this->fromCharCode(($e & 3) << 6 | $c);
        }
        return $f;
    }

    protected function N($b, $e) {
        $c = array();
        $h = 0;
        $d = 0;
        $f = "";
        $g = 0;
        for ($g = 0; 256 > $g; $g++) {
            $c[$g] = $g;
        }
        for ($g = 0; 256 > $g; $g++) {
            $h = ($h + $c[$g] + $this->charCodeAt($b, $g % mb_strlen($b))) % 256;
            $d = $c[$g];
            $c[$g] = $c[$h];
            $c[$h] = $d;
        }

        for ($j = $h = $g = 0; $j < mb_strlen($e); $j++) {
            $g = ($g + 1) % 256;
            $h = ($h + $c[$g]) % 256;
            $d = $c[$g];
            $c[$g] = $c[$h];
            $c[$h] = $d;
            $f .= $this->fromCharCode($this->charCodeAt($e, $j) ^ $c[($c[$g] + $c[$h]) % 256]);
        }
        return $f;
    }

    //从unicode编码返回字符
    protected function fromCharCode($code) {
        return chr($code);
    }

    //返回unicode编码
    protected function charCodeAt($str, $i) {
        $str = mb_substr($str, $i, 1);
        return ord($str);
    }

    protected function O($b, $e) {
        $c = array();
        for ($h = 0; $h < mb_strlen($b); $h++) {
            for ($d = 0, $d = "a" <= $b[$h] && "z" >= $b[$h] ? $this->charCodeAt($b[$h], 0) - 97 : $b[$h] - 0 + 26, $f = 0; 36 > $f; $f++)
                if ($e[$f] == $d) {
                    $d = $f;
                    break;
                }
            $c[$h] = 25 < $d ? $d - 26 : $this->fromCharCode($d + 97);
        }
        array_push($c, "");

        return join("", $c);
    }

}
