<?php

namespace app\modules\manage\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\manage\models\Admin;

/**
 * AdminSearch represents the model behind the search form about `app\modules\manage\models\Admin`.
 */
class AdminSearch extends Admin {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'status', 'last_time'], 'integer'],
            [['username', 'password', 'auth_key', 'nickname', 'last_ip', 'addtime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Admin::find();
        $query->where('id<>1');

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
            'status' => $this->status,
            'last_time' => $this->last_time,
            'addtime' => $this->addtime,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'password', $this->password])
                ->andFilterWhere(['like', 'auth_key', $this->auth_key])
                ->andFilterWhere(['like', 'nickname', $this->nickname])
                ->andFilterWhere(['like', 'last_ip', $this->last_ip]);

        return $dataProvider;
    }

}
