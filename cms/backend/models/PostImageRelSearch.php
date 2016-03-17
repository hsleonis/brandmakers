<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PostImageRel;

/**
 * PostImageRelSearch represents the model behind the search form about `backend\models\PostImageRel`.
 */
class PostImageRelSearch extends PostImageRel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'post_id'], 'integer'],
            [['image', 'short_title', 'short_desc'], 'safe'],
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
        $query = PostImageRel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'post_id' => $this->post_id,
        ]);

        $query->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'short_title', $this->short_title])
            ->andFilterWhere(['like', 'short_desc', $this->short_desc]);

        return $dataProvider;
    }
}
