<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MarkSummary */

$this->title = 'Update Mark Summary: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mark Summaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mark-summary-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
