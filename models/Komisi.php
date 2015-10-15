<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "komisi".
 *
 * @property string $KOM_BELI
 * @property string $KOM_JUAL
 */
class Komisi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'komisi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KOM_BELI', 'KOM_JUAL'], 'required'],
            [['KOM_BELI', 'KOM_JUAL'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'KOM_BELI' => 'Komisi Beli',
            'KOM_JUAL' => 'Komisi Jual',
        ];
    }
}
