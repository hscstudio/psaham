<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Detemiten;

/**
 * DetemitenSearch represents the model behind the search form about `app\models\Detemiten`.
 */
class DetemitenSearch extends Detemiten
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TGL', 'EMITEN_KODE', 'TGLAKHIR'], 'safe'],
            [['JMLLOT', 'JMLSAHAM', 'SALDO', 'SALDOR1', 'HARGA', 'JMLLOTB', 'JMLSAHAMB', 'SALDOB'], 'number'],
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
        $query = Detemiten::find();

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
            'JMLLOT' => $this->JMLLOT,
            'JMLSAHAM' => $this->JMLSAHAM,
            'SALDO' => $this->SALDO,
            'SALDOR1' => $this->SALDOR1,
            'HARGA' => $this->HARGA,
            'TGLAKHIR' => $this->TGLAKHIR,
            'JMLLOTB' => $this->JMLLOTB,
            'JMLSAHAMB' => $this->JMLSAHAMB,
            'SALDOB' => $this->SALDOB,
        ]);

        $query->andFilterWhere(['like', 'EMITEN_KODE', $this->EMITEN_KODE]);

        return $dataProvider;
    }
}
