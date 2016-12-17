<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MarkSummary */

$this->title = 'Create Mark Summary';
$this->params['breadcrumbs'][] = ['label' => 'Mark Summaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mark-summary-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
