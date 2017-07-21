<?php

namespace app\modules\manage\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Member;

/**
 * MemberSearch represents the model behind the search form about `app\models\Member`.
 */
class MemberSearch extends Member
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gid', 'utype', 'status', 'valid', 'valid_date', 'uid', 'last_time', 'login_num', 'play_time', 'has_worker'], 'integer'],
            [['username', 'mobile', 'password', 'encrypt', 'nickname', 'gender', 'photo', 'email', 'qq', 'promote_url', 'last_ip', 'reg_ip', 'addtime', 'remark', 'from_url', 'font_color'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Member::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'gid' => $this->gid,
            'utype' => $this->utype,
            'status' => $this->status,
            'valid' => $this->valid,
            'valid_date' => $this->valid_date,
            'uid' => $this->uid,
            'last_time' => $this->last_time,
            'login_num' => $this->login_num,
            'addtime' => $this->addtime,
            'play_time' => $this->play_time,
            'has_worker' => $this->has_worker,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'encrypt', $this->encrypt])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'qq', $this->qq])
            ->andFilterWhere(['like', 'promote_url', $this->promote_url])
            ->andFilterWhere(['like', 'last_ip', $this->last_ip])
            ->andFilterWhere(['like', 'reg_ip', $this->reg_ip])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'from_url', $this->from_url])
            ->andFilterWhere(['like', 'font_color', $this->font_color]);

        return $dataProvider;
    }
}
