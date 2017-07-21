<?php

namespace app\modules\manage\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
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
    public $oldpwd;
    public $repwd;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'nickname', 'password', 'role_name'], 'required', 'on' => 'create'],
            [['nickname', 'role_name'], 'required', 'on' => 'update'],
            [['oldpwd', 'repwd', 'password', 'nickname'], 'required', 'on' => 'myinfo'],
            ['repwd', 'compare', 'compareAttribute' => 'password', 'on' => 'myinfo', 'message' => '两次密码输入不一致'],
            [['status', 'last_time'], 'integer'],
            [['addtime','oldpwd'], 'safe'],
            [['username'], 'string', 'max' => 20, 'min' => 5],
            [['password'], 'string', 'max' => 32, 'min' => 5],
            [['username'], 'unique', 'message' => '用户名已经存在'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'nickname' => '昵称',
            'status' => '状态',
            'last_time' => '最后登录时间',
            'last_ip' => '最后登录IP',
            'addtime' => '创建时间',
            'password' => '密码',
            'auth_key' => '验证密匙',
            'role_name' => '角色',
            'oldpwd' => '原密码',
            'repwd' => '确认密码',
        ];
    }

}
