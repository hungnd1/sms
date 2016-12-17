<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\MarkSummarySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mark-summary-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="form-group">
        <table>
            <tr>
                <td style="padding-right: 10px">
                    <?=
                    $form->field($model, 'semester')->widget(Select2::classname(), [
                        'hideSearch' => true,
                        'data' => ['1' => 'Học kỳ I', '2' => 'Học kỳ II'],
                        'pluginOptions' => [
                            'allowClear' => false,
                            'width' => '150px'
                        ],
                    ])->label('Theo học kỳ');
                    ?>
                </td>
                <td style="padding-right: 10px">
                    <?=
                    $form->field($model, 'class_id')->widget(Select2::classname(), [
                        'id' => 'class_id',
                        'data' => \yii\helpers\ArrayHelper::map(\common\models\Contact::find()->where(['created_by'=>Yii::$app->user->id])->all(), 'id', 'contact_name'),
                        'pluginOptions' => [
                            'allowClear' => true,
                            'width' => '200px'
                        ],
                    ])->label('Theo lớp');
                    ?>
                </td>
                <td>
                    <?=
                    $form->field($model, 'subject_id')->widget(Select2::classname(), [
                        'data' => \yii\helpers\ArrayHelper::map(\common\models\Subject::find()->all(), 'id', 'name'),
                        'pluginOptions' => [
                            'allowClear' => true,
                            'width' => '200px'
                        ],
                    ])->label('Theo môn học');
                    ?>
                </td>
            </tr>
        </table>

        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
