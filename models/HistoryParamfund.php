<?php

namespace app\models;

use Yii;
use app\models\Paramfund;

/**
 * ParamfundSearch represents the model behind the search form about `app\models\Paramfund`.
 */
class HistoryParamfund extends Paramfund
{
    public $TAHUN_MULAI, $TAHUN_AKHIR, $TRIWULAN_MULAI, $TRIWULAN_AKHIR, $EMITEN_KODES;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TAHUN_MULAI', 'TAHUN_AKHIR', 'TRIWULAN_MULAI', 'TRIWULAN_AKHIR', 'EMITEN_KODES'], 'safe'],
        ];
    }
}
