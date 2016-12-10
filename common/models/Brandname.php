<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "brandname".
 *
 * @property integer $id
 * @property string $brandname
 * @property string $brand_username
 * @property string $brand_password
 * @property string $brand_hash_token
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $expired_at
 * @property integer $created_by
 * @property integer $brand_member
 * @property integer $number_sms
 * @property integer $price_sms
 */
class Brandname extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 0;

    public $price_total;


    public static function tableName()
    {
        return 'brandname';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brand_username', 'brand_password','brandname','number_sms','price_sms','expired_at','brand_member'], 'required','message' => '{attribute} không được để trống', 'on' => 'admin_create_update'],
            [['status', 'created_at', 'updated_at', 'created_by','price_total', 'brand_member', 'number_sms', 'price_sms'], 'integer'],
            [['brandname', 'brand_username', 'brand_password', 'brand_hash_token'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brandname' => 'Brandname',
            'brand_username' => 'Tài khoản',
            'brand_password' => 'Mật khẩu',
            'brand_hash_token' => 'Brand Hash Token',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
            'expired_at' => 'Ngày hết hạn',
            'created_by' => 'Người tạo',
            'brand_member' => 'Chủ sở hữu',
            'number_sms' => 'Số tin',
            'price_sms' => 'Đơn giá',
            'price_total'=>'Số dư'
        ];
    }

    public static function getListStatus()
    {
        return [
            self::STATUS_ACTIVE   => 'Hoạt động',
            self::STATUS_INACTIVE => 'Không hoạt động',
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
    public function setPassword($password)
    {
        $this->brand_password = Yii::$app->security->generatePasswordHash($password);
    }
    public static function formatNumber($number)
    {
        return (new \yii\i18n\Formatter())->asInteger($number);
    }


    public static function getOwner($brand_member = null){

            $brandMember = Brandname::findAll(['status'=>Brandname::STATUS_ACTIVE]);
            $arr = '';
            foreach($brandMember as $item){
                if($brand_member){
                    if($item->brand_member != $brand_member){
                        $arr .= $item->brand_member.',';
                    }
                }else{
                    $arr .= $item->brand_member.',';
                }
            }
            $listId = rtrim($arr,',');
            $user = User::find()->andWhere('id not in ('.$listId.')')
                ->andWhere(['status'=>User::STATUS_ACTIVE])->all();
            return $user;
    }
}
