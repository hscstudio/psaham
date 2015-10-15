<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pembelian;

/**
 * PembelianSearch represents the model behind the search form about `app\models\Pembelian`.
 */
class PembelianSearch extends Pembelian
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NOMOR', 'TGL', 'EMITEN_KODE', 'SECURITAS_KODE'], 'safe'],
            [['JMLLOT', 'HARGA', 'KOM_BELI'], 'number'],
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
        $query = Pembelian::find();

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
            'HARGA' => $this->HARGA,
            'KOM_BELI' => $this->KOM_BELI,
        ]);

        $query->andFilterWhere(['like', 'NOMOR', $this->NOMOR])
            ->andFilterWhere(['like', 'EMITEN_KODE', $this->EMITEN_KODE])
            ->andFilterWhere(['like', 'SECURITAS_KODE', $this->SECURITAS_KODE]);

        return $dataProvider;
    }
}
