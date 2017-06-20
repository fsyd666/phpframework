<?php echo "<?php\n" ?>
namespace <?php echo $dir ?>\Model;

use Think\Model;

class <?php echo $model_name ?>Model extends Model {
public $_fields=array(
//字段
<?php foreach ($_fields as $v) { ?>
    '<?php echo $v ?>'=>'<?php echo ucfirst($v) ?>',
<?php } ?>
);
//自动验证
protected $_validate = array();
//自动完成
protected $_auto = array ();
}
