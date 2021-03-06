<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asset".
 *
 * @property string $TGL
 * @property string $KAS_BANK
 * @property string $TRAN_JALAN
 * @property string $INV_LAIN
 * @property string $STOK_SAHAM
 * @property string $HUTANG
 * @property string $HUT_LANCAR
 * @property string $MODAL
 * @property string $CAD_LABA
 * @property string $LABA_JALAN
 * @property string $UNIT
 * @property string $NAV
 * @property string $TUMBUH
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Asset extends \yii\db\ActiveRecord
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
        return 'asset';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TGL', 'KAS_BANK', 'TRAN_JALAN', 'INV_LAIN', 'STOK_SAHAM', 'HUTANG', 'HUT_LANCAR', 'MODAL', 'CAD_LABA', 'LABA_JALAN', 'UNIT', 'NAV', 'TUMBUH'], 'required'],
            [['TGL'], 'safe'],
            [['KAS_BANK', 'TRAN_JALAN', 'INV_LAIN', 'STOK_SAHAM', 'HUTANG', 'HUT_LANCAR', 'MODAL', 'CAD_LABA', 'LABA_JALAN', 'UNIT', 'NAV', 'TUMBUH'], 'number',
              'enableClientValidation'=> false,
            ],
            [['created_by', 'updated_by','created_at', 'updated_at'], 'safe'],
            //jmllot, jmllotb dan jmlsaham, jmlsahamb
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TGL' => 'Tgl',
            'KAS_BANK' => 'Kas  Bank',
            'TRAN_JALAN' => 'Tran  Jalan',
            'INV_LAIN' => 'Inv  Lain',
            'STOK_SAHAM' => 'Stok  Saham',
            'HUTANG' => 'Hutang',
            'HUT_LANCAR' => 'Hut  Lancar',
            'MODAL' => 'Modal',
            'CAD_LABA' => 'Cad  Laba',
            'LABA_JALAN' => 'Laba  Jalan',
            'UNIT' => 'Unit',
            'NAV' => 'Nav',
            'TUMBUH' => 'Tumbuh',
        ];
    }
}
