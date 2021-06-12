<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Discounts;

/**
 * DiscountsSearch represents the model behind the search form about `common\models\Discounts`.
 */
class DiscountsSearch extends Discounts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'category_id', 'type', 'phone', 'is_active', 'is_approved'], 'integer'],
            [['title', 'sales', 'address', 'text', 'website'], 'safe'],
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
        $query = Discounts::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => [
                'is_approved' => SORT_ASC,
                'id' => SORT_DESC
            ]]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'company_id' => $this->company_id,
            'category_id' => $this->category_id,
            'type' => $this->type,
            'phone' => $this->phone,
            'is_active' => $this->is_active,
            'is_approved' => $this->is_approved,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'sales', $this->sales])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'website', $this->website]);

        return $dataProvider;
    }
}
