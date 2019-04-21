<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "airport_name".
 *
 * @property integer $id
 * @property integer $airport_id
 * @property integer $language_id
 * @property string $value
 */
class AirportName extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function getDb()
    {
        return \Yii::$app->db;
    }

    public static function tableName()
    {
        return 'airport_name';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['airport_id', 'value'], 'required'],
            [['airport_id', 'language_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['airport_id', 'language_id'], 'unique', 'targetAttribute' => ['airport_id', 'language_id'], 'message' => 'The combination of Airport ID and Language ID has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'airport_id' => 'Airport ID',
            'language_id' => 'Language ID',
            'value' => 'Value',
        ];
    }
}
