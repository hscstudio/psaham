<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lotshare".
 *
 * @property string $JML_LBRSAHAM
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Lotshare extends \yii\db\ActiveRecord
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
        return 'lotshare';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['JML_LBRSAHAM'], 'required'],
            [['JML_LBRSAHAM'], 'number'],
            [['created_by', 'updated_by','created_at', 'updated_at'], 'safe'],
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
