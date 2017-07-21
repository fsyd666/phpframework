<?php

namespace app\modules\manage\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $title
 * @property string $perm
 * @property integer $sort
 */
class Menu extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'menu';
    }
    private $_parents = [
        1 => '会员管理',
        2 => '内容管理',
        3 => '管理员管理',
        4 => '系统设置',
        5 => '权限管理'
    ];
    private $_icon = [
        1 => 'icon-male',
        2 => 'icon-archive',
        3 => 'icon-user',
        4 => 'icon-gear',
        5 => 'icon-lock',
    ];

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'route', 'parent'], 'required'],
            [['order'], 'integer'],
            [['name', 'route'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => '标题',
            'route' => '路由',
            'order' => '排序',
            'parent' => '父级菜单'
        ];
    }

    function getParents() {
        return $this->_parents;
    }

    function getMenu() {
        foreach ($this->_parents as $k => $v) {
            $tmp = $this->find()->where(['parent' => $k])->orderBy('order')->asArray()->all();
            if (!$tmp) {
                continue;
            }
            $data[] = ['name' => $v, 'icon' => $this->_icon[$k], 'child' => $tmp];
        }
        return $data;
    }

}
