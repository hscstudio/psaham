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
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property Pembelian[] $pembelians
 */
class Securitas extends \yii\db\ActiveRecord
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
        return 'securitas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KODE', 'NAMA'], 'required'],
            [['KODE'], 'string', 'max' => 8],
            [['NAMA'], 'string', 'max' => 30],
            [['ALAMAT'], 'string', 'max' => 50],
            [['TELP', 'HP'], 'string', 'max' => 15],
            [['CP'], 'string', 'max' => 20],
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
