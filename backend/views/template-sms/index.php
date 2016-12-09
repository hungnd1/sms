<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TemplateSmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \common\models\TemplateSms */
$this->title = 'Tin nhắn mẫu';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp bold uppercase">Tin nhắn mẫu</span>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <p>
                        <?php if(!Yii::$app->params['tvod1Only']) echo Html::a("Thêm tin nhắn mẫu ", Yii::$app->urlManager->createUrl(['/template-sms/create']), ['class' => 'btn btn-success']) ?>
                        <?php if(!Yii::$app->params['tvod1Only']) echo Html::a("Tải tin nhắn mẫu ", Yii::$app->urlManager->createUrl(['/template-sms/upload']), ['class' => 'btn btn-success']) ?>
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
                                'format' => 'raw',
                                'class' => '\kartik\grid\DataColumn',
                                'attribute' => 'template_name',
                                'value'=>function ($model, $key, $index, $widget) {
                                    /** @var $model \common\models\TemplateSms */
                                    return Html::a($model->template_name, ['view', 'id' => $model->id],['class'=>'label label-primary']);

                                },
                            ],
                            [
                                'class' => '\kartik\grid\DataColumn',
                                'attribute' => 'template_content',
                                'value'=>function ($model, $key, $index, $widget) {
                                    /** @var $model \common\models\TemplateSms */
                                    return substr($model->template_content,0,50).'...';
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
                                'filter' => [0 => 'Không hoạt động', 10 => 'Hoạt động'],
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Tất cả'],
                            ],
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
$urlCategory=Yii::$app->urlManager->createUrl("template-sms");
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