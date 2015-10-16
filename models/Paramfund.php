<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paramfund".
 *
 * @property string $EMITEN_KODE
 * @property string $TAHUN
 * @property string $TRIWULAN
 * @property string $BV
 * @property string $P_BV
 * @property string $EPS
 * @property string $P_EPS
 * @property string $PBV
 * @property string $PER
 * @property string $DER
 * @property string $SHARE
 * @property string $HARGA
 * @property string $CE
 * @property string $CA
 * @property string $TA
 * @property string $TE
 * @property string $CL
 * @property string $TL
 * @property string $SALES
 * @property string $NI
 * @property string $ROE
 * @property string $ROA
 * @property string $P_TE
 * @property string $P_SALES
 * @property string $P_NI
 *
 * @property Emiten $eMITENKODE
 */
class Paramfund extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paramfund';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['EMITEN_KODE', 'TAHUN', 'TRIWULAN', 'BV', 'EPS', 'PBV', 'PER', 'DER', 'SHARE', 'HARGA', 'CE', 'CA', 'TA', 'TE', 'CL', 'TL', 'SALES', 'NI', 'ROE', 'ROA'], 'required'],
            [['BV', 'P_BV', 'EPS', 'P_EPS', 'PBV', 'PER', 'DER', 'SHARE', 'HARGA', 'CE', 'CA', 'TA', 'TE', 'CL', 'TL', 'SALES', 'NI', 'ROE', 'ROA', 'P_TE', 'P_SALES', 'P_NI'], 'number',
              'enableClientValidation'=> false,
            ],
            [['EMITEN_KODE'], 'string', 'max' => 8],
            [['TAHUN'], 'string', 'max' => 4],
            [['TRIWULAN'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'EMITEN_KODE' => 'Emiten  Kode',
            'TAHUN' => 'Tahun',
            'TRIWULAN' => 'Triwulan',
            'BV' => 'BV',
            'P_BV' => 'Persentase BV',
            'EPS' => 'EPS',
            'P_EPS' => 'Persentase EPS',
            'PBV' => 'PBV',
            'PER' => 'PER',
            'DER' => 'DER',
            'SHARE' => 'Share',
            'HARGA' => 'Closing Price',
            'CE' => 'Cash Equivalent',
            'CA' => 'Current Asset',
            'TA' => 'Total Asset',
            'TE' => 'Total Equity',
            'CL' => 'Current Liabilities',
            'TL' => 'Total Liabilities',
            'SALES' => 'Sales',
            'NI' => 'Net Income',
            'ROE' => 'ROE',
            'ROA' => 'ROA',
            'P_TE' => 'Persentase TE',
            'P_SALES' => 'Persentase   Sales',
            'P_NI' => 'Persentase Net Income',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmiten()
    {
        return $this->hasOne(Emiten::className(), ['KODE' => 'EMITEN_KODE']);
    }
}
