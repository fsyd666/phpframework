<?php

namespace app\modules\manage\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\manage\models\AuthItem;

/**
 * AdminSearch represents the model behind the search form about `app\modules\manage\models\Admin`.
 */
class AuthItemSearch extends AuthItem {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'description', 'rule_name','data'], 'string'],
            [['name', 'description', 'rule_name', 'data'], 'safe'],
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
        $query = AuthItem::find();

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
        /*$query->andFilterWhere([
            'name' => $this->name,
            'description' => $this->description,
            'rule_name' => $this->rule_name,
            'data' => $this->data,
        ]);*/

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'rule_name', $this->rule_name])
                ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }

}
