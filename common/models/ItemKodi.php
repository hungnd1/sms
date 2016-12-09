<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "item_kodi".
 *
 * @property integer $id
 * @property string $display_name
 * @property string $description
 * @property string $image
 * @property string $image_home
 * @property string $path
 * @property integer $type
 * @property string $file_download
 * @property integer $status
 * @property integer $honor
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $page
 * @property integer $position
 */
class ItemKodi extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 0;


    const TYPE_ADD_ON = 1;
    const TYPE_ITEM = 0;

    const IS_HONOR = 1;
    const NO_IS_HONOR = 0;

    public $category;
    public $addon;
    public $url_image;
    public $list_cat_id;
    public $list_category;
    public $home_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_kodi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['display_name', 'path','page','position'], 'required', 'message' => '{attribute} không được để trống', 'on' => 'admin_create_update'],
            [['type', 'status', 'honor', 'created_at', 'updated_at'], 'integer'],
            [
                [
                    'type',
                    'honor',
                    'home_id',
                    'page',
                    'position',
                    'status',
                    'created_at',
                    'updated_at',
                ],
                'integer',
            ],
            [['description','list_cat_id','list_category','addon','category'], 'string'],
            [['image','url_image','image_home'], 'string', 'max' => 255],
            [['image','image_home'], 'safe'],
            [['image','image_home'],
                'file',
                'tooBig' => ' File ảnh chưa đúng quy cách. Vui lòng thử lại',
                'wrongExtension' => ' File ảnh chưa đúng quy cách. Vui lòng thử lại',
                'skipOnEmpty' => true,
                'extensions' => 'png, jpg, jpeg', 'maxSize' => 10 * 1024 * 1024],
            [['file_download'], 'string', 'max' => 255],
            [['file_download'],
                'file',
                'wrongExtension' => ' File download chưa đúng quy cách. Vui lòng thử lại',
                'skipOnEmpty' => true,
                'extensions' => 'zip'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'display_name' => Yii::t('app', 'Tên hiển thị'),
            'description' => Yii::t('app', 'Mô tả'),
            'status' => Yii::t('app', 'Trạng thái'),
            'url_image' => Yii::t('app', 'Url ảnh đai diện'),
            'image' => Yii::t('app', 'Ảnh đại diện'),
            'image_home' => Yii::t('app', 'Ảnh trang chủ'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'path' => Yii::t('app', 'Đường dẫn'),
            'type' => Yii::t('app', 'Loại'),
            'file_download' => Yii::t('app', 'File download'),
            'honor' => Yii::t('app', 'Nổi bật'),
            'page' => Yii::t('app', 'Trang'),
            'position' => Yii::t('app', 'Vị trí'),
            'list_cat_id' => Yii::t('app', 'Add-on'),
            'list_category' => Yii::t('app', 'Danh mục'),
        ];
    }

    public function getIconUrl()
    {
        return Yii::getAlias($this->image);
    }

    public function getImageLink()
    {
        return $this->image ? Url::to(Yii::getAlias('@web') . DIRECTORY_SEPARATOR . Yii::getAlias('@cat_image') . DIRECTORY_SEPARATOR . $this->image, true) : '';
    }

    public function getImageHomeLink()
    {
        return $this->image_home ? Url::to(Yii::getAlias('@web') . DIRECTORY_SEPARATOR . Yii::getAlias('@cat_image') . DIRECTORY_SEPARATOR . $this->image_home, true) : '';
    }

    public static function getListStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Hoạt động',
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


    public static function getType()
    {
        return [
            self::TYPE_ITEM => 'Item',
            self::TYPE_ADD_ON => 'Add-on',
        ];
    }



    public function getListType()
    {
        if ($this->type == self::TYPE_ITEM) {
            return "Item";
        } else if ($this->type == self::TYPE_ADD_ON) {
            return "Add-on";
        }
    }

    public function getAllCategory($type = 1)
    {
        $res = '';
        $category = KodiCategory::find()->
        select(['kodi_category.display_name'])
            ->innerJoin('kodi_category_item_asm', 'kodi_category_item_asm.category_id = kodi_category.id')
            ->innerJoin('item_kodi', 'item_kodi.id = kodi_category_item_asm.item_id')
            ->andWhere(['kodi_category.type'=>$type])
            ->andWhere(['item_kodi.id' => $this->id])
            ->limit(20)->all();
        foreach ($category as $item) {
            $res .= $item['display_name'].',';
        }
        return rtrim($res,',');
    }

    public function getAllCategoryId($id)
    {
        $res = '';
        $category = KodiCategory::find()->
        select(['kodi_category.id'])
            ->innerJoin('kodi_category_item_asm', 'kodi_category_item_asm.category_id = kodi_category.id')
            ->andWhere(['kodi_category_item_asm.item_id'=>$id])
            ->andWhere(['kodi_category.type'=>KodiCategory::TYPE_CATE])
            ->andWhere(['kodi_category.status'=>self::STATUS_ACTIVE])->all();
        foreach ($category as $item) {
            $res .= $item['id'].',';
        }
        return rtrim($res,',');
    }

    public function getAllCategoryAddon($id)
    {
        $res = '';
        $category = KodiCategory::find()->
        select(['kodi_category.id'])
            ->innerJoin('kodi_category_item_asm', 'kodi_category_item_asm.category_id = kodi_category.id')
            ->andWhere(['kodi_category_item_asm.item_id'=>$id])
            ->andWhere(['kodi_category.type'=>KodiCategory::TYPE_ADDON])
            ->andWhere(['kodi_category.status'=>self::STATUS_ACTIVE])->all();
        foreach ($category as $item) {
            $res .= $item['id'].',';
        }
        return rtrim($res,',');
    }

    public function getListHonor()
    {
        if ($this->honor == self::IS_HONOR) {
            return "Nổi bật";
        } else if ($this->honor == self::NO_IS_HONOR) {
            return "Bình thường";
        }
    }

    public function createCategoryAsm()
    {
        KodiCategoryItemAsm::deleteAll(['item_id' => $this->id]);
        if ($this->list_cat_id || $this->list_category) {
            $listCatIds = explode(',', $this->list_cat_id);
            $listCategory = explode(',',$this->list_category);
            if (is_array($listCatIds) && count($listCatIds) > 0) {
                foreach ($listCatIds as $catId) {
                    $catAsm = new KodiCategoryItemAsm();
                    $catAsm->category_id = $catId;
                    $catAsm->item_id = $this->id;
                    $catAsm->created_at = time();
                    $catAsm->updated_at = time();
                    $catAsm->save();
                }
            }
            if(is_array($listCategory) && count($listCategory) > 0 ){
                foreach ($listCategory as $catId) {
                    $catAsm = new KodiCategoryItemAsm();
                    $catAsm->category_id = $catId;
                    $catAsm->item_id = $this->id;
                    $catAsm->created_at = time();
                    $catAsm->updated_at = time();
                    $catAsm->save();
                }
            }

            return true;
        }

        return true;
    }

}
