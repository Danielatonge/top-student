<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Logs;

/**
 * LogsSearchModel represents the model behind the search form about `backend\models\Logs`.
 */
class LogsSearchModel extends Logs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status_code', 'url',  'response'], 'integer'],
            [['datetime', 'body', 'headers', 'token'], 'safe'],
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
        $query = Logs::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'datetime' => $this->datetime,
            'status_code' => $this->status_code,
            'url' => $this->url,
            'token' => $this->token,
            'response' => $this->response,
        ]);

        $query->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'headers', $this->headers]);

        return $dataProvider;
    }
}
