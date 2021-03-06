<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detemiten".
 *
 * @property string $TGL
 * @property string $EMITEN_KODE
 * @property string $JMLLOT
 * @property string $JMLSAHAM
 * @property string $SALDO
 * @property string $SALDOR1
 * @property string $HARGA
 * @property string $TGLAKHIR
 * @property string $JMLLOTB
 * @property string $JMLSAHAMB
 * @property string $SALDOB
 *
 * @property Emiten $eMITENKODE
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Detemiten extends \yii\db\ActiveRecord
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
        return 'detemiten';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TGL', 'EMITEN_KODE', 'JMLLOT', 'JMLSAHAM', 'SALDO', 'SALDOR1', 'HARGA', 'TGLAKHIR', 'JMLLOTB', 'JMLSAHAMB', 'SALDOB'], 'required'],
            [['TGL', 'TGLAKHIR'], 'safe'],
            [['JMLLOT', 'JMLSAHAM', 'SALDO', 'HARGA', 'SALDOR1', 'JMLLOTB', 'JMLSAHAMB', 'SALDOB'], 'number',
              //'min' => 0,
              'enableClientValidation'=> false,
            ],
            [['JMLLOT', 'JMLSAHAM', 'JMLLOTB', 'JMLSAHAMB'], 'number',
              'min' => 0,
            ],
            //jmllot, jmllotb dan jmlsaham, jmlsahamb

            [['EMITEN_KODE'], 'string', 'max' => 8],
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
    public function getEMITENKODE()
    {
        return $this->hasOne(Emiten::className(), ['KODE' => 'EMITEN_KODE']);
    }
}
