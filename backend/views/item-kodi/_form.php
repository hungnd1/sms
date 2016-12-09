<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\ItemKodi */
/* @var $form yii\widgets\ActiveForm */
$showPreview = !$model->isNewRecord && !empty($model->image);

$showView = !$model->isNewRecord && !empty($model->image_home);

?>

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
    'enableClientValidation' => false,
]); ?>
<div class="form-body">

    <?= $form->field($model, 'display_name')->textInput(['maxlength' => 250, 'class' => 'input-circle']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>




    <?php if ($showView) { ?>
        <div class="form-group field-category-icon">
            <div class="col-sm-offset-3 col-sm-5">
                <?php echo Html::img($model->getImageHomeLink(), ['class' => 'file-preview-image']) ?>
            </div>
        </div>
    <?php } ?>
    <?= $form->field($model, 'image_home')->widget(FileInput::classname(), [
        'options' => ['multiple' => true, 'accept' => 'image/*'],
        'pluginOptions' => [
            'previewFileType' => 'image',
            'showUpload' => false,
            'showPreview' => (!$showView) ? true : false,
            'browseLabel' => '',
            'removeLabel' => '',
            'overwriteInitial' => true
        ]
    ]); ?>
    <div class="row">
        <div class="form-group field-content-price" style="padding-left: 27%;color: red;font-size: 15px;">
            <p>Thứ tự ảnh phải có kích thước và thứ tự chuẩn theo quy định sau:</p>
            <p>Vị trí được quy định bắt đầu từ trái sang phải, từ trên xuống dưới.</p>
            <p>Ví dụ: Heroes Reborn là vị trí 1 có tỉ lệ ngang:dọc 1.2 : 1 </p>
            <p>Noo Phước Thịnh show là vị trí 2 có tỉ lệ ngang:dọc 1 : 1.3</p>
            <p>Adele là vị trí 3 có tỉ lệ ngang:dọc 1.1 : 1</p>
            <p>Vietnam Idol là vị trí 4 có tỉ lệ ngang:dọc 1.1 : 1</p>
            <p>Tru tien là vị trí 5 có tỉ lệ ngang:dọc 2.6 : 1</p>
            <p>Yêu cầu up nội dung chính xác.</p>
            <img src="<?= Url::to("@web/img/Kodi-Home.png") ?>" width="50%" height="50%">
        </div>
    </div>
    <br><br>


    <?php if ($showPreview) { ?>
        <div class="form-group field-category-icon">
            <div class="col-sm-offset-3 col-sm-5">
                <?php echo Html::img($model->getImageLink(), ['class' => 'file-preview-image']) ?>
            </div>
        </div>
    <?php } ?>

    <?= $form->field($model, 'image')->widget(FileInput::classname(), [
        'options' => ['multiple' => true, 'accept' => 'image/*'],
        'pluginOptions' => [
            'previewFileType' => 'image',
            'showUpload' => false,
            'showPreview' => (!$showPreview) ? true : false,
            'browseLabel' => '',
            'removeLabel' => '',
            'overwriteInitial' => true
        ]
    ]); ?>
    <div class="row">
        <div class="form-group field-content-price" style="padding-left: 27%;color: red;font-size: 15px;">
            <p>Ảnh truyền hình có tỉ lệ ngang:dọc 1.6:1</p>
            <p>Ảnh phim có tỉ lệ ngang:dọc 1:1.5</p>
            <p>Ảnh clip có tỉ lệ ngang:dọc 1:1</p>
            <p>Ảnh âm thanh có tỉ lệ ngang:dọc 1:1</p>
            <p>Ảnh thể thao có tỉ lệ ngang:dọc 1.7:1</p>
            <p>Yêu cầu up nội dung chính xác.</p>
        </div>
    </div>
    <br><br>
    <?= $form->field($model, 'status')->dropDownList(
        \common\models\ItemKodi::getListStatus(), ['class' => 'input-circle']
    ) ?>
    <?= $form->field($model, 'path')->textInput(['class' => 'input-circle']) ?>


    <div class="row">

        <div class="form-group field-content-price">
            <label class="control-label col-md-2">Danh mục (*)</label>

            <div class="col-md-10">
                <?= \common\widgets\Jstree::widget([
                    'clientOptions' => [
                        "checkbox" => ["keep_selected_style" => false],
                        "plugins" => ["checkbox"]
                    ],
                    'id' => 'tree',
                    'type_kodi' => 3,
                    'cat' => 2,
                    'data' => isset($selectedCats) ? $selectedCats : [],
                    'eventHandles' => [
                        'changed.jstree' => "function(e,data) {
                            jQuery('#list-category-id').val('');
                            var i, j, r = [];
                            var catIds='';
                            for(i = 0, j = data.selected.length; i < j; i++) {
                                var item = $(\"#\" + data.selected[i]);
                                var value = item.attr(\"id\");
                                if(i==j-1){
                                    catIds += value;
                                } else{
                                    catIds += value +',';

                                }
                            }
                            jQuery(\"#list-category-id\").val(catIds);
                            console.log(jQuery(\"#list-category-id\").val());
                         }"
                    ]
                ]) ?>
            </div>
            <div class="col-md-offset-2 col-md-10"></div>
            <div class="col-md-offset-2 col-md-10">
                <div class="help-block"></div>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'list_category')->hiddenInput(['id' => 'list-category-id'])->label(false) ?>
    <div class="row">

        <div class="form-group field-content-price">
            <label class="control-label col-md-2">Addon (*)</label>

            <div class="col-md-10">
                <?= \common\widgets\Jstree::widget([
                    'clientOptions' => [
                        "checkbox" => ["keep_selected_style" => false],
                        "plugins" => ["checkbox"]
                    ],
                    'id' => 'tree_id',
                    'type_kodi' => 1,
                    'cat' => 1,
                    'data' => isset($selectedAdds) ? $selectedAdds : [],
                    'eventHandles' => [
                        'changed.jstree' => "function(e,data) {
                            jQuery('#list-cat-id').val('');
                            var i, j, r = [];
                            var catIds='';
                            for(i = 0, j = data.selected.length; i < j; i++) {
                                var item = $(\"#\" + data.selected[i]);
                                var value = item.attr(\"id\");
                                if(i==j-1){
                                    catIds += value;
                                } else{
                                    catIds += value +',';

                                }
                            }
                            jQuery(\"#list-cat-id\").val(catIds);
                            console.log(jQuery(\"#list-cat-id\").val());
                         }"
                    ]
                ]) ?>
            </div>
            <div class="col-md-offset-2 col-md-10"></div>
            <div class="col-md-offset-2 col-md-10">
                <div class="help-block"></div>
            </div>
        </div>
    </div>
    <?= $form->field($model, 'list_cat_id')->hiddenInput(['id' => 'list-cat-id'])->label(false) ?>


</div>


<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <?= Html::submitButton($model->isNewRecord ? 'Tạo Item' : 'Cập nhật',
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::a('Quay lại', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

