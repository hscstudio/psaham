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
 * @property string $JMLSAHAMB
 * @property string $SALDOB
 * @property string $last_update
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property Detemiten[] $detemitens
 * @property Paramfund[] $paramfunds
 * @property Pembelian[] $pembelians
 */
class Emiten extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
            ],
            'blameable' => [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'attributes' => [
                        \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_by','updated_by'],
                        \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'emiten';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KODE', 'NAMA', 'JMLLOT', 'JMLSAHAM', 'SALDO', 'HARGA', 'SALDOR1', 'JMLLOTB', 'SALDOB'], 'required'],
            [['JMLLOT', 'JMLSAHAM', 'SALDO', 'HARGA', 'SALDOR1', 'JMLLOTB', 'JMLSAHAMB', 'SALDOB'], 'number',
              'enableClientValidation'=> false,
            ],
            [['JMLLOT', 'JMLSAHAM', 'JMLLOTB', 'JMLSAHAMB'], 'number',
              'min' => 0,
            ],
            [['KODE'], 'string', 'max' => 8],
            [['NAMA'], 'string', 'max' => 50],
            [['created_by', 'updated_by','created_at', 'updated_at'], 'safe'],
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
            'JMLSAHAM' => 'Share',
            'SALDO' => 'Saldo',
            'HARGA' => 'Harga',
            'SALDOR1' => 'Saldo BJ',
            'JMLLOTB' => 'Jmllotb',
            'JMLSAHAMB' => 'Share B',
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
