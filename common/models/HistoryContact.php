<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "history_contact".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $brandname_id
 * @property integer $template_id
 * @property string $content
 * @property string $campain_name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $send_schedule
 * @property integer $member_by
 */
class HistoryContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const TYPE_CSKH = 1; // loai tin nhan cham soc khach hang
    const TYPE_ADV = 2; // loai tin nhan quang cao
    public $is_send;
    public static function tableName()
    {
        return 'history_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'campain_name'], 'required','message' => '{attribute} không được để trống', 'on' => 'admin_create_update'],
            [['type', 'brandname_id','is_send','template_id', 'created_at', 'updated_at', 'member_by'], 'integer'],
            [['content', 'campain_name','send_schedule'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Kiểu tin nhắn',
            'brandname_id' => 'Brandname',
            'template_id' => 'Tin nhắn mẫu',
            'content' => 'Nội dung',
            'campain_name' => 'Tên chiến dịch',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
            'send_schedule' => 'Thời gian gửi',
            'member_by' => 'Người tạo',
        ];
    }

    public static function getListType()
    {
        return [
            self::TYPE_CSKH   => 'Tin nhắn chăm sóc khách hàng',
            self::TYPE_ADV => 'Tin nhắn quảng cáo',
        ];
    }

    public function getTypeName()
    {
        $listType = self::getListType();
        if (isset($listType[$this->type])) {
            return $listType[$this->type];
        }
        return '';
    }
}
