<?php

namespace app\modules\admin\models;

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
        4 => '权限管理',
        5 => '系统管理'
    ];

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title', 'perm', 'fid'], 'required'],
            [['sort'], 'integer'],
            [['title', 'perm'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => '标题',
            'perm' => '权限',
            'sort' => '排序',
            'fid' => '父级菜单'
        ];
    }

    function getParents() {
        return $this->_parents;
    }

    function getMenu() {
        foreach ($this->_parents as $k => $v) {
            $tmp = $this->find()->where(['fid' => $k])->orderBy('sort')->asArray()->all();
            if (!$tmp) {
                continue;
            }
            $data[] = ['title' => $v, 'child' => $tmp];
        }
        return $data;
    }

}
