<?php

namespace app\modules\manage\models;

use Yii;
use yii\rbac\Item;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 */
class AuthItem extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'auth_item';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'type', 'description'], 'required'],
            ['name','match','pattern'=>'/^[a-zA-Z0-9\*_\/]+$/','message'=>'只允许使用a-zA-Z0-9*_/'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => '名称',
            'type' => '类型',
            'description' => '描述',
            'rule_name' => '规则名',
            'data' => '数据',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 添加角色
     * @return boolean
     */
    public function addRole() {
        $auth = \Yii::$app->authManager;
        //判断是否已经有此角色名称了
        if ($auth->getRole($this->name)) {
            Yii::$app->getSession()->setFlash('error', '名称已经存在');
            return false;
        }
        $role = $auth->createRole($this->name);
        $role->description = $this->description;
        if ($auth->add($role)) {
            if ($pers = Yii::$app->request->post('pers')) {
                foreach ($pers as $v) {
                    $child = $auth->getPermission($v);
                    $auth->addChild($role, $child);
                }
            }
        }
        return true;
    }

    /**
     * 更新角色
     * @return boolean
     */
    function updateRole() {
        $auth = Yii::$app->authManager;

        $oldName = $this->getOldAttribute('name');
        if ($oldName != $this->name && $auth->getRole($this->name)) {
            Yii::$app->getSession()->setFlash('error', '此名称已经存在');
            return false;
        }
        $role = $auth->createRole($this->name);
        $role->description = $this->description;
        if ($auth->update($oldName, $role)) {
            if ($pers = Yii::$app->request->post('pers')) {
                //先删除所有的子项目
                $auth->removeChildren($role);
                foreach ($pers as $v) {
                    $child = $auth->getPermission($v);
                    $auth->addChild($role, $child);
                }
            }
        }
        return true;
    }

    /**
     * 添加权限
     * @return boolean
     */
    public function addPerm() {
        $auth = \Yii::$app->authManager;
        //判断是否已经有此权限名称了
        if ($auth->getPermission($this->name)) {
            Yii::$app->getSession()->setFlash('error', '名称已经存在');
            return false;
        }
        $prem = $auth->createPermission($this->name);
        $prem->description = $this->description;
        //添加规则
        if ($this->rule_name) {
            $prem->ruleName = $this->rule_name;
        }
        //添加附加数据
        if ($this->data) {
            $prem->data = $this->data;
        }
        return $auth->add($prem);
    }

    /**
     * 更新权限
     * @return boolean
     */
    public function updatePerm() {
        $auth = \Yii::$app->authManager;
        $oldName = $this->getOldAttribute('name');
        //判断是否已经有此权限名称了
        if ($oldName != $this->name && $auth->getPermission($this->name)) {
            Yii::$app->getSession()->setFlash('error', '名称已经存在');
            return false;
        }
        $prem = $auth->createPermission($this->name);
        $prem->description = $this->description;
        //添加规则
        if ($this->rule_name) {
            $prem->ruleName = $this->rule_name;
        }
        //添加附加数据
        if ($this->data) {
            $prem->data = $this->data;
        }
        return $auth->update($oldName, $prem);
    }

    /**
     * 获取规则
     * @return array
     */
    public function getAuthRule() {
        $data = AuthRule::find()->all();
        return ArrayHelper::map($data, 'name', 'name');
    }

    public function getRoles() {
        $tmp = $this->findAll(['type' => 1]);
        $data = [];
        if (is_array($tmp)) {
            foreach ($tmp as $v) {
                $data[$v->name] = $v->description ? $v->description : $v->name;
            }
        }
        return $data;
    }

}
