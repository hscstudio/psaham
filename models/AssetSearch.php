<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Asset;

/**
 * AssetSearch represents the model behind the search form about `app\models\Asset`.
 */
class AssetSearch extends Asset
{
    public $start, $end;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TGL'], 'safe'],
            [['start','end'], 'safe'],
            [['KAS_BANK', 'TRAN_JALAN', 'INV_LAIN', 'STOK_SAHAM', 'HUTANG', 'HUT_LANCAR', 'MODAL', 'CAD_LABA', 'LABA_JALAN', 'UNIT', 'NAV', 'TUMBUH'], 'number'],
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
        $query = Asset::find();

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
            'KAS_BANK' => $this->KAS_BANK,
            'TRAN_JALAN' => $this->TRAN_JALAN,
            'INV_LAIN' => $this->INV_LAIN,
            'STOK_SAHAM' => $this->STOK_SAHAM,
            'HUTANG' => $this->HUTANG,
            'HUT_LANCAR' => $this->HUT_LANCAR,
            'MODAL' => $this->MODAL,
            'CAD_LABA' => $this->CAD_LABA,
            'LABA_JALAN' => $this->LABA_JALAN,
            'UNIT' => $this->UNIT,
            'NAV' => $this->NAV,
            'TUMBUH' => $this->TUMBUH,
        ]);

        //if(!empty($start)){
            //$query->andFilterWhere(['between', 'TGL', $this->start, $this->end]);
            $query->andFilterWhere(['>=', 'TGL', $this->start]);
        //}
        //if(!empty($end)){
            $query->andFilterWhere(['<=', 'TGL', $this->end]);
        //}

        return $dataProvider;
    }
}
