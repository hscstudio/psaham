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
 */
class Assetat extends \yii\db\ActiveRecord
{
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
            [['KAS_BANK', 'TRAN_JALAN', 'INV_LAIN', 'STOK_SAHAM', 'HUTANG', 'HUT_LAIN', 'MODAL', 'CAD_LABA', 'LABA_JALAN', 'UNITAT', 'NAVAT'], 'number']
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
