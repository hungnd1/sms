<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Brandname */

$this->title = $model->brandname;
$this->params['breadcrumbs'][] = ['label' => 'Brandname', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-sms-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'brandname',
            'brand_username',
            'number_sms',
            'price_sms',
            [
                'label' => $model->getAttributeLabel('price_total'),
                'attribute' => 'price_total',
                'value' => \common\models\Brandname::formatNumber($model->price_sms * $model->number_sms). ' VNĐ'
            ],
            [
                'label' => $model->getAttributeLabel('status'),
                'attribute' => 'status',
                'value' => $model->getStatusName()
            ],
            [
                'label' => $model->getAttributeLabel('brand_member'),
                'attribute' => 'brand_member',
                'value' => \common\models\User::findOne(['id'=>$model->brand_member])->username
            ],
            [
                'attribute' => 'expired_at',
                'value' => date('d-m-Y H:i:s', $model->created_at)
            ],
            [
                'attribute' => 'created_at',
                'value' => date('d-m-Y H:i:s', $model->created_at)
            ],
            [
                'attribute' => 'updated_at',
                'value' => date('d-m-Y H:i:s', $model->updated_at)
            ],

        ],
    ]) ?>

</div>
