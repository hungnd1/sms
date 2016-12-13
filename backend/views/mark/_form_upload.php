<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Mark */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- Tải file mẫu -->
<?php $form_download = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'action' => ['download-template'],
    'fullSpan' => 8,
    'options' => ['enctype' => 'multipart/form-data'],
    'formConfig' => [
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'labelSpan' => 3,
        'deviceSize' => ActiveForm::SIZE_SMALL,
    ],
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
]); ?>

<div class="form-body">

    <div class="caption" style="margin: 10px 0 0 10px">
        <i class="fa fa-cogs font-green-sharp"></i>
        <span class="caption-subject font-green-sharp bold uppercase">Tải file mẫu</span>
    </div>
    <div class="tools">
        <a href="javascript:;" class="collapse">
        </a>
    </div>

    <div class="row">
        <?=
        $form_download->field($model, 'subject_id')->widget(Select2::classname(), [
            'size' => Select2::MEDIUM,
            'data' => \yii\helpers\ArrayHelper::map(\common\models\Subject::find()->all(), 'id', 'name'),
            'pluginOptions' => [
                'allowClear' => true,
                'width' => '50%'
            ],
            'options' => ['placeholder' => 'Select a state ...', 'multiple' => true],
        ])->label('Chọn môn học');
        ?>

        <div class="form-group field-content-price" style="padding-left: 27%;font-size: 15px;">
            <?= Html::submitButton('Tải file mẫu', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>


<!-- Tải lên danh sách điểm -->
<?php $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'fullSpan' => 8,
    'options' => ['enctype' => 'multipart/form-data'],
    'formConfig' => [
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'labelSpan' => 3,
        'deviceSize' => ActiveForm::SIZE_SMALL,
    ],
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
]); ?>


<div class="form-body">

    <div class="caption" style="margin: 10px 0 0 10px">
        <i class="fa fa-cogs font-green-sharp"></i>
        <span class="caption-subject font-green-sharp bold uppercase">Tải lên danh sách điểm</span>
    </div>
    <div class="tools">
        <a href="javascript:;" class="collapse">
        </a>
    </div>

    <?=
    $form->field($model, 'semester')->widget(Select2::classname(), [
        'hideSearch' => true,
        'data' => ['1' => 'Học kỳ I', '2' => 'Học kỳ II'],
        'pluginOptions' => [
            'allowClear' => false,
            'width' => '50%'
        ],
    ])->label('Chọn học kỳ:');
    ?>

    <?=
    $form->field($model, 'class_id')->widget(Select2::classname(), [
        'data' => ['1' => 'Học kỳ I', '2' => 'Học kỳ II'],
        'pluginOptions' => [
            'allowClear' => true,
            'width' => '50%'
        ],
    ])->label('Chọn lớp:');
    ?>

    <?= $form->field($model, 'file')->widget(FileInput::classname(), [
        'options' => ['multiple' => true, 'accept' => '*'],
        'pluginOptions' => [
            'previewFileType' => 'any',
            'showUpload' => false,
            'showPreview' => false,
            'browseLabel' => '',
            'removeLabel' => '',
            'overwriteInitial' => true
        ]
    ])->label('Chọn file tải lên:'); ?>

    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <?= Html::submitButton('Tải lên', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Quay lại', ['index'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
