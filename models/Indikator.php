<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "indikator".
 *
 * @property string $TGL
 * @property string $NAMA
 * @property string $NAVAT
 * @property string $NAV
 * @property string $TUMBUH
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Indikator extends \yii\db\ActiveRecord
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
        return 'indikator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TGL', 'NAMA', 'NAVAT', 'NAV', 'TUMBUH'], 'required'],
            [['TGL'], 'safe'],
            [['NAVAT', 'NAV', 'TUMBUH'], 'number','enableClientValidation'=> false],
            [['NAMA'], 'string', 'max' => 100],
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
            'NAMA' => 'Nama',
            'NAVAT' => 'Navat',
            'NAV' => 'Nav',
            'TUMBUH' => 'Tumbuh',
        ];
    }
}
