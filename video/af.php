<?php

//很重要   很多是这个原因导致 charCodeAt解码不一致问题。
mb_internal_encoding('ISO-8859-1');


$data = "Od+wtNeC3wXtfdQBJB4pnF5VoMGIDEK4o0rly7mUcqeKYXpC5Q/GkksvmgvoTuQ+8TSO6Snqt2WIXp0KTWJpK1E5/3aXipZj0JR7nf2foHZwDBx6wEWHUgc6zdPMR/gqedSvKEeCu/ZQzyfCm4UYLg/UaV7fpOgxtBiTsWIelL0OjwKhMIa/hWlWl3x/7Hc+Vbivm3Z0dmKrtQDYd5KnH75qXFQ83WR7hcKpILzTkeUYWqu+ZWTe1X9nxX/sP51Y2p6P+HeqlZESKHbsXmihTJ2UThQMKX97jDL9dk0oB+XJlHxTsjJIVY/+YCYbAX6WMuaBYRNzWu2/ohvcvfqvfMbD07hAccXKbSFnPpTGJ1LAd5jjMZ2eLGUPopBBKUJ+oVE/VzujTMCnMfcdY8AgnPAqS879AhniTBNjtrVVAUS0DO9RL+kCGbSQGN/tYHHc0bsPxF+KePj3yDfPaSszkaU13Iy24mAexK+aUQ/ZzgNEHcHFD8sBFcogoKTuz/p9wrDPlnlFpGKkRm2xHBP9CdOCCT8MObW4ZquHYzq8wrsWiEiVpHF6txDSXCsKbM3EgB026Zslg/rmAGE3ChzfGRqv6xEWaOqGWlEVA36CRNhm1oA6sPKlBaPWThNC7APC0ngtmJxOViP+Y6i4EMvgd6foiGQaw0SY+tqamnPGI6T9HoK8ouCIt4DZG9Fgyjt423FGZ3hxiE8xHuYSOub5ZhmkDgeqk8i1d5m2URJpa7zMkGZ9IRSYoavXQikfU30xLOBNO+SKHq5P2vwKGWWdj7FUJbv0DRmeAiukvdp2Hch23wC9I4Hp1sW3FHJxzV9ISOtVzY7GUQ9pC9J71+qdsXfAwADrKA7Oro06oMoWXtqZE5AKgzJfUG5S1T/RYBwI9VZscr8xGu7NsiFHZitW2Lal+aZKT5sHHQslRuRkNWIeS/QqTj+lzfWcyTYEHnjrKJSPUs7yhDB5d/JNoWENY0aFjB+FQMwH1PQfrIbF6mmKYi8ya6uxXV7N8MaKcEcj1kmGpqwSgZjWPSzgTrlfFzs3BoygPb5+ngcfkRlaspfYsb1XYzY62vOlK6ymNXrzmFWht7XsygP5s9K1DS7JX4nVfz1qeVbyOzuy47X3Nwig1PWkKWkrUl6aQdQNHS39dQmnxnQxP8lxOyKeliOHsmxUq3rsHc3y3mDHtKqnTY0sZLmPzWe2sQAYnj+Xz1PUmSW/PlFTe1Vt9TlS6DzVM4nvthcY9pt+UHcwhAa35DjDindCV9xu8UgMc/H737ckp4rF0OnHPsTF7GT8LXWDktScA//rViuUdkCwovYe5wtoXEGJ3MHLe6V+ktcO0YKrN+edP0ZE3SDMua0d/mldJr5KxqZsDpABYO9fjtHMRJtG3l9Db36U7ANJL0gr53mcFBw4t04g4sq6lqlPogXKOeZhKN03t4Rfs64lW2NekpJpuGxhBh7/hXA1HVtRFSSXYTVcgZYm0TeajeuuH4mqahDTM7MgZgxBK4qg1a2NTRBMWO34XKpgN/F2u2aaUo6GRBcJ2KZLMWYflMtxDNpKvENQKqEYRC8OAurooG/7jtiSrxq5fk+RwD8NYxb299pLsWzfEE7v3WZe/bP5VoVfzthwZwzZLl0GUXZyrg3zWhpy3WCBqt7+aRv9ZkEqcTI6Rpw07tTrfAJNImF239zfbioVVHbzfDZt62Qi7g";
$key = "d2ViaW5mbzEyM2pzb24=";


//$str=pack('H*','39dfb0b4d782');

//$str=  mb_convert_encoding($str, 'UTF-8','GBK');

//echo charCodeAt($str,2);

print_r(json_decode(base64_decode(basea17kdv($data, base64_decode($key))),true));

function basea17kdv($e, $key) {
    $key = md5($key);
    $key_length = strlen($key);
    $string = base64_decode($e);
        
    $string_length = strlen($string);
    $rndkey = array();
    $box =array();
    $result = '';
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = charCodeAt($key,$i % $key_length);
        $box[$i] = $i;
    }
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= fromCharCode(charCodeAt($string,$i) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if (substr($result,0, 8) == substr(md5(substr($result,8) . $key),0, 8)) {
        if (!e) {
            $videodata = substr($result,8);
        } else {
            return substr($result,8);
        }
    }
}

//从unicode编码返回字符
function fromCharCode($code) {
    return chr($code);
}

//返回unicode编码
function charCodeAt($str, $i) {    
    $str = mb_substr($str, $i, 1);
    return ord($str);
}
