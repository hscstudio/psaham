<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Emiten;

/**
 * EmitenSearch represents the model behind the search form about `app\models\Emiten`.
 */
class EmitenSearch extends Emiten
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KODE', 'NAMA'], 'safe'],
            [['JMLLOT', 'JMLSAHAM', 'SALDO', 'HARGA', 'SALDOR1', 'JMLLOTB', 'SALDOB'], 'number'],
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
        $query = Emiten::find();

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
            'JMLLOT' => $this->JMLLOT,
            'JMLSAHAM' => $this->JMLSAHAM,
            'SALDO' => $this->SALDO,
            'HARGA' => $this->HARGA,
            'SALDOR1' => $this->SALDOR1,
            'JMLLOTB' => $this->JMLLOTB,
            'SALDOB' => $this->SALDOB,
        ]);

        $query->andFilterWhere(['like', 'KODE', $this->KODE])
            ->andFilterWhere(['like', 'NAMA', $this->NAMA]);

        return $dataProvider;
    }
}
