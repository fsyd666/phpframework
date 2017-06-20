<?php

/**
 * 数据备份
 * config  数据库 的信息
 * path  数据库备份文件 存放路径
 * filename 数据库备份文件名 
 */
namespace Org\Util;
class DbBack {

    private $config = array();
    private $dblink;
    public $path = './Database/';
    private $tailed = '/*#one end#*/';
    private $tables = array();          //当前数据库 表
    private $str_cont = '';
    function __construct($path = '') {
        $this->config=array(
            'port' => C('DB_PORT'),
            'host' => C('DB_HOST'),
            'charset' => C('DB_CHARSET'),
            'username' => C('DB_USER'),
            'password' => C('DB_PWD'),
            'dbname' => C('DB_NAME')
        );
        if ($path != '')
            $this->path = $path;

        $this->trimPath(); //替换  路径分割符
        /* 判断 路径是否存在 */
        if (!is_dir($this->path)) {
            mkdir($this->path);
        }

        $this->conn(); //连接数据库
    }

    protected function conn() {
        if ($this->dblink = mysql_connect($this->config['host'] . ':' . $this->config['port'], $this->config['username'], $this->config['password'])) {
            mysql_query("set NAMES '{$this->config['charset']}'");
            if (!mysql_select_db($this->config['dbname']))
                $this->throwException('打开数据库失败');
            //获取当前数据库 的所有表
            $rs = mysql_query("SHOW TABLES FROM {$this->config['dbname']}");
            while ($row = mysql_fetch_array($rs)) {
                $this->tables[] = $row[0];
            }
        } else {
            throw new Exception('无法连接到数据库!');
        }
    }
    //获取当前表
    function getTables(){
        return $this->tables;
    }
    function backup($arrTable=null) {
        /* 为数据表 添加 sql 语句 */
        $this->str_cont = '/*the file is database backup ' . date('Y-m-d H:i:s') . "*/\n\r";  //起始  说明语句
        if(!$arrTable)
            $arrTable=  $this->tables;
        if(!is_array($arrTable))
            return false;
        foreach ($arrTable as $t) {
            $this->str_cont.="DROP TABLE IF EXISTS `$t`;{$this->tailed}\n";
            $rs = mysql_query("SHOW CREATE TABLE {$t}");
            while ($row = mysql_fetch_row($rs)) {
                //创建数据表 结构 
                $this->str_cont.=$row[1] . ";{$this->tailed}\n\r";
            }
            //获取数据内容  创建 数据
            $rs = mysql_query("SELECT * FROM {$t}");
            while ($row = mysql_fetch_row($rs)) {
                $value = '';
                //单引号转义
                foreach ($row as $v) {
                    $value.=",'" . addslashes($v) . "'";
                }
                $value = substr($value, 1);
                $this->str_cont.="INSERT INTO {$t} VALUES($value);$this->tailed\n";
            }
            $this->str_cont.="\r";
        }
        //创建文件
        $filename = $this->path . time() . '.bak';
        if ($handle = fopen($filename, 'w'))
            if (fwrite($handle, $this->str_cont))
                return $filename;
            else
                return false;
    }

    /**
     * 数据库还原
     */
    function restore($filename) {
        $str = file_get_contents($this->path . $filename);
        if(!$str)
             $this->throwException('读取文件错误:'.$this->path . $filename);
        $arr = explode($this->tailed, $str);
        array_pop($arr);
        foreach ($arr as $v) {
            if (!mysql_query($v))
                $this->throwException('执行sql语句错误:' . $v);
        }
        return true;
    }

    //替换 路径分隔符
    protected function trimPath() {
        $this->path = str_replace(array('/', '\\', '//', '\\\\'), DIRECTORY_SEPARATOR, $this->path);
    }

    protected function throwException($error) {
        throw new Exception($error);
    }
    
    //数据库 优化 
    function optimize($arrTable=null){
        if(!$arrTable)
            $arrTable=  $this->tables;
        foreach($arrTable as $t){
            mysql_query('OPTIMIZE TABLE '.$t);
        }
        return true;
    }
}

?>
