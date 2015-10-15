<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Securitas;

/**
 * SecuritasSearch represents the model behind the search form about `app\models\Securitas`.
 */
class SecuritasSearch extends Securitas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KODE', 'NAMA', 'ALAMAT', 'TELP', 'CP', 'HP'], 'safe'],
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
        $query = Securitas::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'KODE', $this->KODE])
            ->andFilterWhere(['like', 'NAMA', $this->NAMA])
            ->andFilterWhere(['like', 'ALAMAT', $this->ALAMAT])
            ->andFilterWhere(['like', 'TELP', $this->TELP])
            ->andFilterWhere(['like', 'CP', $this->CP])
            ->andFilterWhere(['like', 'HP', $this->HP]);

        return $dataProvider;
    }
}
