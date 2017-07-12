<?php

namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class AdminUser extends ActiveRecord implements IdentityInterface {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'admin';
    }

    /**
     * 根据用户名查找用户
     * @param type $username
     * @return \static
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username]);
    }

    /**
     * 根据给到的ID查询身份。
     * 保存数据到 session 防止下次使用 再去数据库查询
     * @param string|integer $id 被查询的ID
     * @return IdentityInterface|null 通过ID匹配到的身份对象
     */
    public static function findIdentity($id) {
        $session = \Yii::$app->session;
        if ($session['admin']) {
            return new static($session['admin']);
        } else {
            $session['admin'] = static::findone($id);
            $session['admin']->password = null;
            return $session['admin'];
        }
    }

    /**
     * 根据 token 查询身份。
     *
     * @param string $token 被查询的 token
     * @return IdentityInterface|null 通过 token 得到的身份对象
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string 当前用户ID
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string 当前用户的（cookie）认证密钥
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * 验证密码
     * @param type $password
     * @return type
     */
    public function validatePassword($password) {
        return $this->password === md5($password);
    }

}
