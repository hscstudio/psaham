<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "securitas".
 *
 * @property string $KODE
 * @property string $NAMA
 * @property string $ALAMAT
 * @property string $TELP
 * @property string $CP
 * @property string $HP
 *
 * @property Pembelian[] $pembelians
 */
class Securitas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'securitas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KODE', 'NAMA', 'ALAMAT', 'TELP', 'CP', 'HP'], 'required'],
            [['KODE'], 'string', 'max' => 8],
            [['NAMA'], 'string', 'max' => 30],
            [['ALAMAT'], 'string', 'max' => 50],
            [['TELP', 'HP'], 'string', 'max' => 15],
            [['CP'], 'string', 'max' => 20]
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
            'ALAMAT' => 'Alamat',
            'TELP' => 'Telp',
            'CP' => 'Cp',
            'HP' => 'Hp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPembelians()
    {
        return $this->hasMany(Pembelian::className(), ['SECURITAS_KODE' => 'KODE']);
    }
}
