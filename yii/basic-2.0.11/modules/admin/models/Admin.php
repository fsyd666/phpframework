<?php

namespace app\modules\admin\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $user
 * @property string $pwd
 * @property string $auth_key
 * @property string $nickname
 * @property integer $status
 * @property integer $last_time
 * @property string $last_ip
 * @property string $addtime
 */
class Admin extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'admin';
    }

    public $role_name;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user', 'nickname', 'pwd'], 'required', 'on' => 'create'],
            [['nickname', 'role_name'], 'required', 'on' => 'update'],
            [['status', 'last_time'], 'integer'],
            [['addtime'], 'safe'],
            [['user'], 'string', 'max' => 20, 'min' => 5],
            [['pwd'], 'string', 'max' => 32, 'min' => 5],
            [['user'], 'unique', 'message' => '用户名已经存在'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user' => '用户名',
            'nickname' => '昵称',
            'status' => '状态',
            'last_time' => '最后登录时间',
            'last_ip' => '最后登录IP',
            'addtime' => '创建时间',
            'pwd' => '密码',
            'auth_key' => '验证密匙',
            'role_name' => '角色',
        ];
    }

}
