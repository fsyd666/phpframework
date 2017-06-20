<?php echo '<?php' ?>

/**
* <?php echo $title ?>控制器
*/

namespace Admin\Controller;

use Think\Controller;

class <?php echo $model ?>Controller extends CommonController {

    public $model = '<?php echo $model ?>';
    public function _initialize() {
        parent::_initialize();
        <?php foreach ($fields as $key => $v) { ?>           
            <?php if (strpos($key, 'id')) { ?>
                $this->assign('<?php echo $key ?>',D('<?php echo $key ?>')->getField('id,name'));
            <?php } ?>
        <?php } ?>
    }
    //列表
    public function index() {
    if (!empty($_GET['stype'])) {
        $stype = $_GET['stype'];
        switch ($stype){
        <?php foreach ($fields as $key => $v) { ?>
            <?php if (strpos($key, 'id')) { ?>
                case '<?php echo $key ?>':
                $param['where'] = "$stype = {$_GET['<?php echo $key ?>']}";
                break;
            <?php } ?>
        <?php } ?>
            default :
            $param['where'] = "$stype like '%{$_GET['skey']}%'";
        }           
        $list = $this->page(D($this->model), $param);
    } else {
        $list = $this->page(D($this->model));
    }
    $this->assign('list', $list);
    cookie('edit_prev_url',__SELF__);
    $this->display();
}

    //添加
    public function add() {
        if (IS_POST) {
            $m = D($this->model);
            if (!$m->create()) {
                $this->error($m->getError());
            }
            if ($m->add()) {
                $this->success('添加成功');
            } else {
                $this->error('添加失败');
            }
        }
        $this->assign('action_name','添加');
        //带有checkbox的默认值  1默认是开 0默认是关闭
        $this->assign('data',array('status'=>1));        
        $this->display('form');
    }

    //编辑
    public function edit($id) {
        $m = D($this->model);
        if (IS_POST) {            
                if (!$m->create()) {
                $this->error($m->getError());
            }
            if (false!==$m->save()) {
                $this->success('修改成功',cookie('edit_prev_url'));
            } else {
                $this->error('修改失败');
            }
        }
        $this->assign('action_name','修改')            
        ->assign('data',$m->find($id));       
        $this->display('form');
    }
    //查看
    public function view($id) {
        $this->assign('data', D($this->model)->find($id));
        $this->display();
    }   
    //导出到Excel
    function toExcel() {
        $m=D($this->model);
        $data['title']=array(
            <?php foreach($fields as $k=>$v){ ?>
            '<?php echo $k ?>'=>'<?php echo $v ?>',
            <?php } ?>          
        );
        $data['data']=$m->field(array_keys($data['title']))->select();
        $this->data2excel($data,'<?php echo $model ?>');
    }
    //从Excel导入
    function fromExcel(){
        $file=$this->uploadExcelFile('excel_file');
        $field_key=array(
        <?php foreach($fields as $k=>$v){ ?>
        <?php $i++; ?>
            '<?php echo chr(64+$i) ?>'=>'<?php echo $k ?>',
        <?php } ?>
        );
        $signature=array(
            'A1'=>'<?php echo current($fields) ?>',
            'B1'=>'<?php echo next($fields) ?>'
        );
        $this->excel2data($file, $field_key, $this->model, $signature);
    }
}
