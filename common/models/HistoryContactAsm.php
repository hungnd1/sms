<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "history_contact_asm".
 *
 * @property integer $id
 * @property integer $history_contact_id
 * @property integer $contact_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $content_number
 * @property string  $api_sms_id
 * @property integer $history_contact_status
 */
class HistoryContactAsm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history_contact_asm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['history_contact_id', 'contact_id'], 'required'],
            [['history_contact_id','content_number','history_contact_status', 'contact_id', 'created_at', 'updated_at'], 'integer'],
            [['api_sms_id'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'history_contact_id' => 'History Contact ID',
            'contact_id' => 'Contact ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
