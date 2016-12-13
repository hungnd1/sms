<?php

use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ContactDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách chi tiết của danh bạ ' . \common\models\Contact::findOne(['id' => $id])->contact_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Thông tin chi tiết danh bạ</span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <?php $form = ActiveForm::begin([
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'fullSpan' => 10,
                    'options' => ['enctype' => 'multipart/form-data'],

                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                ]); ?>
                <div class="col-md-2" style="margin-right: -40px;">
                    <?php echo Html::a("Thêm danh sách chi tiết ", Yii::$app->urlManager->createUrl(['/contact-detail/create', 'id' => $id]), ['class' => 'btn btn-success']) ?>
                </div>
                <div class="col-md-2" style="margin-right: -40px;">
                    <?php echo Html::a("Tải file mẫu  ", Yii::$app->urlManager->createUrl(['/contact/download-template']), ['class' => 'btn btn-danger']) ?>
                </div>
                <div class="col-md-3" style="margin-left: -40px;">
                    <?= $form->field($model, 'file')->widget(FileInput::classname(), [
                        'options' => ['multiple' => true, 'accept' => '*'],
                        'pluginOptions' => [
                            'previewFileType' => 'any',
                            'showUpload' => false,
                            'showPreview' => false,
                            'browseLabel' => '',
                            'removeLabel' => '',
                            'overwriteInitial'=>true
                        ]
                    ]); ?>
                </div>
                <div class="col-md-2" style="margin-left: -70px;">
                    <?= Html::button('Tải dữ liệu', ['class' => 'btn btn-success','onclick'=>'move();']) ?>
                </div>
                <?php ActiveForm::end(); ?>
                <br><br>
                <br><br>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'id' => 'grid-category-ida',
                    'filterModel' => $searchModel,
                    'responsive' => true,
                    'pjax' => true,
                    'hover' => true,
                    'columns' => [
                        [
                            'class' => 'kartik\grid\CheckboxColumn',
                            'headerOptions' => ['class' => 'kartik-sheet-style'],
                        ],
                        [
                            'format' => 'raw',
                            'width' => '15%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'fullname',
                            'value' => function ($model, $key, $index, $widget) {
                                /** @var $model \common\models\ContactDetail */
                                return Html::a($model->fullname, ['/contact-detail/view', 'id' => $model->id], ['class' => 'label label-primary']);

                            },
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'gender',
                            'value' => function ($model, $key, $index, $widget) {
                                /** @var $model \common\models\ContactDetail */
                                return $model->gender == 1 ? 'Nam' : 'Nữ';
                            },
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'address',
                            'value' => function ($model, $key, $index, $widget) {
                                /** @var $model \common\models\ContactDetail */
                                return $model->address;
                            },
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'phone_number',
                            'value' => function ($model, $key, $index, $widget) {
                                /** @var $model \common\models\ContactDetail */
                                return $model->phone_number;
                            },
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'email',
                            'value' => function ($model, $key, $index, $widget) {
                                /** @var $model \common\models\ContactDetail */
                                return $model->email;
                            },
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'company',
                            'value' => function ($model, $key, $index, $widget) {
                                /** @var $model \common\models\ContactDetail */
                                return $model->company;
                            },
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'created_by',
                            'value' => function ($model, $key, $index, $widget) {
                                /** @var $model \common\models\ContactDetail */
                                return \common\models\User::findOne(['id' => $model->created_by])->username;
                            },
                        ],
                        [
                            'format' => 'raw',
                            'class' => '\kartik\grid\DataColumn',
                            'width' => '15%',
                            'label' => 'Ngày sinh',
                            'filterType' => GridView::FILTER_DATE,
                            'attribute' => 'birthday',
                            'value' => function ($model) {
                                return date('d-m-Y', $model->birthday);
                            }
                        ],
                        [
                            'class' => 'kartik\grid\DataColumn',
                            'attribute' => 'status',
                            'label' => 'Trạng thái',
                            'format' => 'html',
                            'value' => function ($model) {
                                /* @var $model \common\models\ContactDetail */
                                return $model->getStatusName();
                            },
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => [0 => 'Không hoạt động', 10 => 'Hoạt động'],
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'Tất cả'],
                        ],
                        ['class' => 'kartik\grid\ActionColumn',
                            'template' => '{view}{update}{delete}',
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['contact-detail/view', 'id' => $model->id]), [
                                        'title' => 'Thông tin chi tiết',
                                    ]);

                                },
                            ]
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

<script>
    function move(){
        alert(1);
        var fileVal=document.getElementById("contactdetail-file");
        var id = '<?= $id ?>';
        var file_data = $('#contactdetail-file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        $.ajax({
            url: '<?= Url::toRoute(['contact-detail/upload']) ?>',
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(data){
                var responseJSON = jQuery.parseJSON(data);
                if(responseJSON.status=="ok"){
                    $.ajax({
                        type:'POST',
                        url:'<?= Url::toRoute(['contact-detail/update-contact']) ?>',
                        beforeSend: function(){
                            //code;
                        },
                        data:{id:id},
                        success: function(data){
                            var responseJSON = jQuery.parseJSON(data);
                            if(responseJSON.status=="ok"){
                                alert('Upload thành công');
                                location.reload();
                            }
                            else{
                                alert('Upload thất bại');
                                location.reload();
                            }
                        }
                    });
                }else{
                    alert('Upload thất bại');
                    location.reload();
                }
            }
        });

    }

</script>