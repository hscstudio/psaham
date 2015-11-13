<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "komisi".
 *
 * @property string $KOM_BELI
 * @property string $KOM_JUAL
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Komisi extends \yii\db\ActiveRecord
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
        return 'komisi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KOM_BELI', 'KOM_JUAL'], 'required'],
            [['KOM_BELI', 'KOM_JUAL'], 'number'],
            [['created_by', 'updated_by','created_at', 'updated_at'], 'safe'],
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
