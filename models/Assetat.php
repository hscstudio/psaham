<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "assetat".
 *
 * @property string $TGL
 * @property string $KAS_BANK
 * @property string $TRAN_JALAN
 * @property string $INV_LAIN
 * @property string $STOK_SAHAM
 * @property string $HUTANG
 * @property string $HUT_LAIN
 * @property string $MODAL
 * @property string $CAD_LABA
 * @property string $LABA_JALAN
 * @property string $UNITAT
 * @property string $NAVAT
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Assetat extends \yii\db\ActiveRecord
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
        return 'assetat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TGL', 'KAS_BANK', 'TRAN_JALAN', 'INV_LAIN', 'STOK_SAHAM', 'HUTANG', 'HUT_LAIN', 'MODAL', 'CAD_LABA', 'LABA_JALAN', 'UNITAT', 'NAVAT'], 'required'],
            [['TGL'], 'safe'],
            [['KAS_BANK', 'TRAN_JALAN', 'INV_LAIN', 'STOK_SAHAM', 'HUTANG', 'HUT_LAIN', 'MODAL', 'CAD_LABA', 'LABA_JALAN', 'UNITAT', 'NAVAT'], 'number',
              'enableClientValidation'=> false,
            ],
            [['created_by', 'updated_by','created_at', 'updated_at'], 'safe'],
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
            'HUT_LAIN' => 'Hut  Lain',
            'MODAL' => 'Modal',
            'CAD_LABA' => 'Cad  Laba',
            'LABA_JALAN' => 'Laba  Jalan',
            'UNITAT' => 'Unitat',
            'NAVAT' => 'Navat',
        ];
    }
}
