<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contact_detail".
 *
 * @property integer $id
 * @property string $fullname
 * @property string $phone_number
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $gender
 * @property string $address
 * @property integer $birthday
 * @property string $email
 * @property string $company
 * @property string $notes
 * @property integer $created_by
 * @property integer $contact_id
 */
class ContactDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact_detail';
    }

    public $file;
    const GENDER_MALE = 1;
    const GENDER_FEMAILE = 2;


    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone_number','fullname','email','status'], 'required','message' => '{attribute} không được để trống', 'on' => 'admin_create_update'],
            [['status', 'created_at', 'updated_at', 'gender', 'created_by', 'contact_id'], 'integer'],
            [['fullname', 'notes','birthday'], 'string', 'max' => 500],
            [['phone_number'], 'string', 'max' => 20],
            [['address','file'], 'string', 'max' => 250],
            [['email', 'company'], 'string', 'max' => 100],
            [
                'phone_number',
//                'match', 'pattern' => '/^0[0-9]$/',
                'match', 'pattern' => '/^(84)\d{9,10}$/',
                'message' => 'Số điện thoại không hợp lệ - Định dạng số điện thoại bắt đầu với số 84, ví dụ 84912345678, 8412312341234'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Họ và tên',
            'phone_number' => 'Số điện thoại',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
            'gender' => 'Giới tính',
            'address' => 'Địa chỉ',
            'birthday' => 'Ngày sinh',
            'email' => 'Email',
            'company' => 'Công ty',
            'notes' => 'Ghi chú',
            'created_by' => 'Người tạo',
            'contact_id' => 'Contact ID',
        ];
    }


    public static function getListStatus()
    {
        return [
            self::STATUS_ACTIVE   => 'Hoạt động',
            self::STATUS_INACTIVE => 'Không hoạt động',
        ];
    }

    public static function getListGender()
    {
        return [
            self::GENDER_MALE   => 'Nam',
            self::GENDER_FEMAILE => 'Nữ',
        ];
    }

    public function getStatusName()
    {
        $listStatus = self::getListStatus();
        if (isset($listStatus[$this->status])) {
            return $listStatus[$this->status];
        }
        return '';
    }
}
