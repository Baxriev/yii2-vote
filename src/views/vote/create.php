<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\VoteQuestions */

$this->title = 'Create Vote Questions';
$this->params['breadcrumbs'][] = ['label' => 'Vote Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vote-questions-create">

    <?php echo \oks\langs\widgets\LangsWidgets::widget(); ?>

    <?= $this->render('_form', [
        'model' => $model,
        'question' => $question
    ]) ?>

</div>
