<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MarkSummarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Điểm tổng kết';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Điểm tổng kết</span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>

            <div class="portlet-body">
                <p>
                    <?php if (!Yii::$app->params['tvod1Only']) echo Html::a("Tải lên điểm tổng kết", Yii::$app->urlManager->createUrl(['/mark-summary/view-upload']), ['class' => 'btn btn-success']) ?>
                    <?php if (!Yii::$app->params['tvod1Only']) echo Html::a("Xuất điểm tổng kết", Yii::$app->urlManager->createUrl(['/mark-summary/view-export']), ['class' => 'btn btn-success']) ?>
                </p>

                <div style="margin: 25px 0 25px 0">
                    <?= $this->render('_search', [
                        'model' => $searchModel,
                    ]) ?>
                </div>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'id' => 'grid-mark-summary-id',
                    'filterModel' => $searchModel,
                    'responsive' => true,
                    'pjax' => true,
                    'hover' => true,

                    'columns' => [
                        // Checkbox
                        [
                            'class' => '\kartik\grid\CheckboxColumn',
                            'width' => '5%'
                        ],
                        // STT
                        [
                            'class' => '\kartik\grid\SerialColumn',
                            'header' => 'STT',
                            'width' => '5%'
                        ],
                        // Name
                        [
                            'format' => 'raw',
                            'label' => 'Tên học sinh',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                $student = \common\models\ContactDetail::findOne($model->student_id);
                                return $student->fullname;
                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                            'width' => '15%'
                        ],
                        // Mieng
                        [
                            'format' => 'raw',
                            'label' => 'Điểm tổng kết',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                if (strcmp(explode(';', $model->marks)[0], 'N') == 0) {
                                    return '';
                                }
                                return explode(';', $model->marks)[0];
                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
