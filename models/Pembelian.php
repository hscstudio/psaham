<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pembelian".
 *
 * @property string $NOMOR
 * @property string $TGL
 * @property string $JMLLOT
 * @property string $HARGA
 * @property string $KOM_BELI
 * @property string $EMITEN_KODE
 * @property string $SECURITAS_KODE
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property Emiten $eMITENKODE
 * @property Securitas $sECURITASKODE
 */
class Pembelian extends \yii\db\ActiveRecord
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
        return 'pembelian';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NOMOR', 'TGL', 'JMLLOT', 'JMLSAHAM', 'HARGA', 'KOM_BELI','EMITEN_KODE', 'SECURITAS_KODE'], 'required'],
            [['TGL'], 'safe'],
            [['JMLLOT', 'JMLSAHAM', 'HARGA', 'KOM_BELI','TOTAL_BELI'], 'number',
                'enableClientValidation'=> false,
                //'numberPattern' => '/^\s*[-+]?([0-9]\,?)+[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/mig',
            ],
            [['JMLLOT', 'JMLSAHAM'], 'number',
              'min' => 0,
            ],
            [['NOMOR'], 'string', 'max' => 6],
            [['EMITEN_KODE', 'SECURITAS_KODE'], 'string', 'max' => 8],
            [['created_by', 'updated_by','created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NOMOR' => 'Nomor',
            'TGL' => 'Tgl',
            'JMLLOT' => 'Jml lot',
            'JMLSAHAM' => 'Jml Saham',
            'HARGA' => 'Harga',
            'KOM_BELI' => 'Kom  Beli',
            'EMITEN_KODE' => 'Emiten  Kode',
            'SECURITAS_KODE' => 'Securitas  Kode',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmiten()
    {
        return $this->hasOne(Emiten::className(), ['KODE' => 'EMITEN_KODE']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSecuritas()
    {
        return $this->hasOne(Securitas::className(), ['KODE' => 'SECURITAS_KODE']);
    }
}
