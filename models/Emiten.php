<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "emiten".
 *
 * @property string $KODE
 * @property string $NAMA
 * @property string $JMLLOT
 * @property string $JMLSAHAM
 * @property string $SALDO
 * @property string $HARGA
 * @property string $SALDOR1
 * @property string $JMLLOTB
 * @property string $SALDOB
 *
 * @property Detemiten[] $detemitens
 * @property Paramfund[] $paramfunds
 * @property Pembelian[] $pembelians
 */
class Emiten extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'emiten';
    }

    public function behaviors()
    {
      return [
          [
              'class' => TimestampBehavior::className(),
              'attributes' => [
                  ActiveRecord::EVENT_BEFORE_INSERT => ['last_update'],
                  ActiveRecord::EVENT_BEFORE_UPDATE => ['last_update'],
              ],
          ],
      ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KODE', 'NAMA', 'JMLLOT', 'JMLSAHAM', 'SALDO', 'HARGA', 'SALDOR1', 'JMLLOTB', 'SALDOB'], 'required'],
            [['JMLLOT', 'JMLSAHAM', 'SALDO', 'HARGA', 'SALDOR1', 'JMLLOTB', 'SALDOB'], 'number',
              'min' => 0,
              'enableClientValidation'=> false,
            ],
            [['last_update'], 'integer'],
            [['KODE'], 'string', 'max' => 8],
            [['NAMA'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'KODE' => 'Kode',
            'NAMA' => 'Nama',
            'JMLLOT' => 'Jml lot',
            'JMLSAHAM' => 'Jml Saham',
            'SALDO' => 'Saldo',
            'HARGA' => 'Harga',
            'SALDOR1' => 'Saldor1',
            'JMLLOTB' => 'Jmllotb',
            'SALDOB' => 'Saldob',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetemitens()
    {
        return $this->hasMany(Detemiten::className(), ['EMITEN_KODE' => 'KODE']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParamfunds()
    {
        return $this->hasMany(Paramfund::className(), ['EMITEN_KODE' => 'KODE']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPembelians()
    {
        return $this->hasMany(Pembelian::className(), ['EMITEN_KODE' => 'KODE']);
    }
}
