<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detemiten".
 *
 * @property string $TGL
 * @property string $EMITEN_KODE
 * @property string $JMLLOT
 * @property string $SALDO
 * @property string $HARGA
 * @property string $TGLAKHIR
 * @property string $JMLLOTB
 * @property string $SALDOB
 *
 * @property Emiten $eMITENKODE
 */
class Detemiten extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detemiten';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TGL', 'EMITEN_KODE', 'JMLLOT', 'SALDO', 'HARGA', 'TGLAKHIR', 'JMLLOTB', 'SALDOB'], 'required'],
            [['TGL', 'TGLAKHIR'], 'safe'],
            [['JMLLOT', 'SALDO', 'HARGA', 'JMLLOTB', 'SALDOB'], 'number'],
            [['EMITEN_KODE'], 'string', 'max' => 8]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TGL' => 'Tgl',
            'EMITEN_KODE' => 'Emiten  Kode',
            'JMLLOT' => 'Jmllot',
            'SALDO' => 'Saldo',
            'HARGA' => 'Harga',
            'TGLAKHIR' => 'Tglakhir',
            'JMLLOTB' => 'Jmllotb',
            'SALDOB' => 'Saldob',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEMITENKODE()
    {
        return $this->hasOne(Emiten::className(), ['KODE' => 'EMITEN_KODE']);
    }
}
