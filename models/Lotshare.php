<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lotshare".
 *
 * @property string $JML_LBRSAHAM
 */
class Lotshare extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lotshare';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['JML_LBRSAHAM'], 'required'],
            [['JML_LBRSAHAM'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'JML_LBRSAHAM' => 'Jml  Lbrsaham',
        ];
    }
}
