<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý Item ';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp bold uppercase">Quản lý Item</span>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <p>
                        <?php if(!Yii::$app->params['tvod1Only']) echo Html::a("Tạo item ", Yii::$app->urlManager->createUrl(['/item-kodi/create']), ['class' => 'btn btn-success']) ?>
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'id'=>'grid-category-id',
                        'filterModel' => $searchModel,
                        'responsive' => true,
                        'pjax' => true,
                        'hover' => true,
                        'columns' => [
                            [
                                'class' => '\kartik\grid\DataColumn',
                                'attribute' => 'display_name',
                                'label' => 'Tên hiển thị',
                                'value'=>function ($model, $key, $index, $widget) {
                                    /** @var $model \common\models\ItemKodi */
                                    return $model->display_name;
                                },
                            ],
                            [
                                'class' => '\kartik\grid\DataColumn',
                                'attribute' => 'description',
                                'label' => 'Mô tả',
                                'value'=>function ($model, $key, $index, $widget) {
                                    /** @var $model \common\models\ItemKodi */
                                    return \common\helpers\CUtils::subString($model->description,20);
                                },
                            ],
                            [
                                'class' => '\kartik\grid\DataColumn',
                                'format'=>'raw',
                                'label'=>'Ảnh đại diện',
                                'attribute' => 'image',
                                'value'=>function ($model, $key, $index, $widget) {
                                    /** @var $model \common\models\ItemKodi */
                                    $cat_image=  Yii::getAlias('@cat_image');
                                    return $model->image ? Html::img('@web/'.$cat_image.'/'.$model->image, ['alt' => 'Thumbnail','width'=>'50','height'=>'50']) : '';
                                },
                            ],

                            [
                                'format' => 'raw',
                                'class' => '\kartik\grid\DataColumn',
                                'width'=>'15%',
                                'label' => 'Ngày tạo',
                                'filterType' => GridView::FILTER_DATE,
                                'attribute' => 'created_at',
                                'value' => function($model){
                                    return date('d-m-Y H:i:s', $model->created_at);
                                }
                            ],
                            [
                                'format' => 'raw',
                                'class' => '\kartik\grid\DataColumn',
                                'width'=>'15%',
                                'label' => 'Ngày cập nhật',
                                'filterType' => GridView::FILTER_DATE,
                                'attribute' => 'updated_at',
                                'value' => function($model){
                                    return date('d-m-Y H:i:s', $model->updated_at);
                                }
                            ],
                            [
                                'class' => 'kartik\grid\EditableColumn',
                                'attribute' => 'status',
                                'label'=>'Trạng thái',
                                'format' => 'html',
                                'refreshGrid' => true,
                                'editableOptions' => function ($model, $key, $index) {
                                    return [
                                        'header' => 'Trạng thái',
                                        'size' => 'md',
                                        'displayValueConfig' => $model->listStatus,
                                        'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                                        'data' => $model->listStatus,
                                        'placement' => \kartik\popover\PopoverX::ALIGN_LEFT
                                    ];
                                },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => [0 => 'InActive', 10 => 'Active'],
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Tất cả'],
                            ],

                            [
                                'class' => '\kartik\grid\DataColumn',
                                'attribute' => 'addon',
                                'format' => 'html',
                                'width'=>'15%',
                                'label' => 'Addon',
                                'value'=>function ($model, $key, $index, $widget) {
                                    /** @var $model \common\models\ItemKodi */
                                    return $model->getAllCategory(\common\models\KodiCategory::TYPE_ADDON);
                                },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => \common\models\KodiCategory::getListAddonCate(\common\models\KodiCategory::TYPE_ADDON),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => "Tất cả"],
                            ],
                            [
                                'class' => '\kartik\grid\DataColumn',
                                'attribute' => 'category',
                                'format' => 'html',
                                'width'=>'15%',
                                'label' => 'Danh mục',
                                'value'=>function ($model, $key, $index, $widget) {
                                    /** @var $model \common\models\ItemKodi */
                                    return $model->getAllCategory(\common\models\KodiCategory::TYPE_CATE);
                                },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => \common\models\KodiCategory::getListAddonCate(\common\models\KodiCategory::TYPE_CATE),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => "Tất cả"],
                            ],
//                            [
//                                'class' => '\kartik\grid\DataColumn',
//                                'attribute' => 'honor',
//                                'label' => 'Nổi bật',
//                                'value'=>function ($model, $key, $index, $widget) {
//                                    /** @var $model \common\models\ItemKodi */
//                                    return $model->getListHonor();
//                                },
//                            ],

                            [
                                'class' => 'kartik\grid\ActionColumn',
//                            'dropdown' => true,
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

<?php
$urlCategory=Yii::$app->urlManager->createUrl("kodi-category");
Yii::info($urlCategory);
$js=<<<JS

function moveCategory(urlType,id) {
    var url;
    switch (urlType) {
        case 1:
            url = "move-up";
            break;
        case 2:
            url = "move-down";
            break;
        case 3:
            url = "move-back";
            break;
        case 4:
            url = "move-forward";
            break;
    }
    $.ajax({

        type:'GET',
        url: '{$urlCategory}'+'/'+ url,

        data: {'id':id},
        success:function(data) {
            $.pjax.reload({container:'#grid-category-id'});

        }
    });
}
JS;
$this->registerJs($js,$this::POS_HEAD);
