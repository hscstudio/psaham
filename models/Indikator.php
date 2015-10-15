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
 */
class Indikator extends \yii\db\ActiveRecord
{
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
            [['NAVAT', 'NAV', 'TUMBUH'], 'number'],
            [['NAMA'], 'string', 'max' => 100]
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
