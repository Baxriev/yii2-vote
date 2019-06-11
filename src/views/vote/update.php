<?php

use oks\langs\widgets\LangsWidgets;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\VoteQuestions */

$this->title = 'Update Vote Questions: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Vote Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vote-questions-update">

    <?= $this->render('_form', [
        'model' => $model,
        'question' => $question
    ]) ?>

</div>
