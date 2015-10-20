<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Indikator;

/**
 * IndikatorSearch represents the model behind the search form about `app\models\Indikator`.
 */
class IndikatorSearch extends Indikator
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TGL', 'NAMA'], 'safe'],
            [['NAVAT', 'NAV', 'TUMBUH'], 'number'],
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
        $query = Indikator::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'TGL' => $this->TGL,
            'NAVAT' => $this->NAVAT,
            'NAV' => $this->NAV,
            'TUMBUH' => $this->TUMBUH,
        ]);

        $query->andFilterWhere(['like', 'NAMA', $this->NAMA]);

        return $dataProvider;
    }
}
