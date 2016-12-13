<?php

use kartik\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel common\models\MarkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Điểm môn học';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Điểm môn học</span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">

                <p>
                    <?php if (!Yii::$app->params['tvod1Only']) echo Html::a("Tải lên điểm môn học", Yii::$app->urlManager->createUrl(['/mark/upload']), ['class' => 'btn btn-success']) ?>
                    <?php if (!Yii::$app->params['tvod1Only']) echo Html::a("Xuất điểm môn học", Yii::$app->urlManager->createUrl(['/mark/upload']), ['class' => 'btn btn-success']) ?>
                </p>

                <div style="margin: 25px 0 25px 0">
                    <?= $this->render('_search', [
                        'model' => $searchModel,
                    ]) ?>
                </div>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'id' => 'grid-subject-id',
                    'filterModel' => $searchModel,
                    'responsive' => true,
                    'pjax' => true,
                    'hover' => true,
                    'beforeHeader' => [
                        [
                            'columns' => [
                                ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center']],
                                ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center']],
                                ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center ']],
                                ['content' => 'Miệng', 'options' => ['colspan' => 5, 'class' => 'text-center']],
                                ['content' => '15\'', 'options' => ['colspan' => 5, 'class' => 'text-center']],
                                ['content' => '1 Tiết', 'options' => ['colspan' => 5, 'class' => 'text-center']],
                                ['content' => 'Thi HK', 'options' => ['colspan' => 1, 'class' => 'text-center']],
                                ['content' => 'TBHK', 'options' => ['colspan' => 1, 'class' => 'text-center']],
                                ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center']],
                            ],
                            'options' => ['class' => 'skip-export'] // remove this row from export
                        ]
                    ],

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
                            'value' => function ($searchModel) {
                                return $searchModel->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        // Mieng
                        [
                            'format' => 'raw',
                            'label' => '1',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        [
                            'format' => 'raw',
                            'label' => '2',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        [
                            'format' => 'raw',
                            'label' => '3',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        [
                            'format' => 'raw',
                            'label' => '4',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        [
                            'format' => 'raw',
                            'label' => '5',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        // 15'
                        [
                            'format' => 'raw',
                            'label' => '1',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        [
                            'format' => 'raw',
                            'label' => '2',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        [
                            'format' => 'raw',
                            'label' => '3',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        [
                            'format' => 'raw',
                            'label' => '4',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        [
                            'format' => 'raw',
                            'label' => '5',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        // 1 tiết
                        [
                            'format' => 'raw',
                            'label' => '1',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        [
                            'format' => 'raw',
                            'label' => '2',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        [
                            'format' => 'raw',
                            'label' => '3',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        [
                            'format' => 'raw',
                            'label' => '4',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        [
                            'format' => 'raw',
                            'label' => '5',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        // Thi HK
                        [
                            'format' => 'raw',
                            'label' => '1',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        // TBHK
                        [
                            'format' => 'raw',
                            'label' => '1',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

                            },
                            'headerOptions' => ['style' => 'text-align:center'],
                            'mergeHeader' => true,
                            'enableSorting' => false,
                        ],
                        //Xếp hạng
                        [
                            'format' => 'raw',
                            'label' => 'Xếp hạng',
                            'width' => '5%',
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'value' => function ($model) {
                                return $model->id;

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
