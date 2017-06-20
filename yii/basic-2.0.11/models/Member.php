<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "member".
 *
 * @property string $id
 * @property integer $gid
 * @property integer $utype
 * @property string $username
 * @property string $mobile
 * @property string $password
 * @property string $encrypt
 * @property string $nickname
 * @property string $gender
 * @property string $photo
 * @property string $email
 * @property string $qq
 * @property integer $status
 * @property integer $valid
 * @property integer $valid_date
 * @property integer $uid
 * @property string $promote_url
 * @property string $last_time
 * @property string $last_ip
 * @property string $reg_ip
 * @property integer $login_num
 * @property string $addtime
 * @property string $remark
 * @property integer $play_time
 * @property string $from_url
 * @property integer $has_worker
 * @property string $font_color
 */
class Member extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'utype', 'status', 'valid', 'valid_date', 'uid', 'last_time', 'login_num', 'play_time', 'has_worker'], 'integer'],
            [['gender'], 'string'],
            [['addtime'], 'safe'],
            [['username', 'mobile', 'nickname', 'qq', 'last_ip', 'reg_ip'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 32],
            [['encrypt', 'font_color'], 'string', 'max' => 10],
            [['photo', 'promote_url', 'from_url'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 30],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gid' => '组ID',
            'utype' => '会员类型',
            'username' => '用户名',
            'nickname' => '昵称',
            'gender' => 'Gender',
        ];
    }
}
