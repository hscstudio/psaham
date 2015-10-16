<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Paramfund;

/**
 * ParamfundSearch represents the model behind the search form about `app\models\Paramfund`.
 */
class ParamfundSearch extends Paramfund
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['EMITEN_KODE', 'TAHUN', 'TRIWULAN'], 'safe'],
            [['BV', 'P_BV', 'EPS', 'P_EPS', 'PBV', 'PER', 'DER', 'SHARE', 'HARGA', 'CE', 'CA', 'TA', 'TE', 'CL', 'TL', 'SALES', 'NI', 'ROE', 'ROA', 'P_TE', 'P_SALES', 'P_NI'], 'number'],
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
        $query = Paramfund::find();

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
            'BV' => $this->BV,
            'P_BV' => $this->P_BV,
            'EPS' => $this->EPS,
            'P_EPS' => $this->P_EPS,
            'PBV' => $this->PBV,
            'PER' => $this->PER,
            'DER' => $this->DER,
            'SHARE' => $this->SHARE,
            'HARGA' => $this->HARGA,
            'CE' => $this->CE,
            'CA' => $this->CA,
            'TA' => $this->TA,
            'TE' => $this->TE,
            'CL' => $this->CL,
            'TL' => $this->TL,
            'SALES' => $this->SALES,
            'NI' => $this->NI,
            'ROE' => $this->ROE,
            'ROA' => $this->ROA,
            'P_TE' => $this->P_TE,
            'P_SALES' => $this->P_SALES,
            'P_NI' => $this->P_NI,
        ]);

        $query->andFilterWhere(['like', 'EMITEN_KODE', $this->EMITEN_KODE])
            ->andFilterWhere(['like', 'TAHUN', $this->TAHUN])
            ->andFilterWhere(['like', 'TRIWULAN', $this->TRIWULAN]);

        return $dataProvider;
    }
}
