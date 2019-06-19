<?php
/**
 * Created by PhpStorm.
 * User: OKS
 * Date: 17.06.2019
 * Time: 11:09
 */
?>
<div class="vote-wrapper">
    <div class="title"><?= count($vote) > 0 ? $vote->title : $answer['title']; ?></div>
    <?php if (count($vote) > 0 ) : ?>
        <form id="vote-form-id"  class="vote-form <?=count($vote) == 0 ?: 'show'?>" >
            <?php foreach ($answers as $answer) : ?>
                <label class="vote" data-id="<?=$answer->id?>" data-question="<?=$vote->id?>">
                    <input type="checkbox"> <span class="circle"></span> <span
                            class="text"><?=$answer->title?></span>
                </label>
            <?php endforeach; ?>
        </form>
    <?php endif; ?>
    <div id="vote-result-id" class="vote-result <?=count($vote) > 0 ?: 'show'?>">
        <?php foreach ($dataToResponse as $result) : ?>
            <div class="result">
                <div class="result-title"><?= $result['answer'] ?> <?= ceil($result['count'] * 100 / array_sum($summ)) ?>%</div>
                <div class="resut-block" style="width: <?= ceil($result['count'] * 100 / array_sum($summ)) ?>%;"></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
$js = <<<JS
var submited = false;

$('.vote').click(function () {
    if(!submited){
        submited = true;
        var answer_id = $(this).data("id");
        var questions_id = $(this).data("question");
        $.ajax({
            url: '/vote/vote-result/result',
            type: 'POST',
            data: {
                answer_id: answer_id,
                questions_id: questions_id
            },
            success: function(res){
                submited = false;
                $('#vote-form-id').removeClass('show');
                $('#vote-result-id').addClass('show');
                $(function() {
                    $.each(res.dataToResponse, function(item, value) {
                        $('.vote-result').append('<div class="result"><div class="result-title">' + value.answer + '  ' + Math.ceil(value.count * 100 / res.summ) + '</div></div>'); 
                        $('.vote-result').append('<div class="result"><div class="resut-block" style="width: ' + Math.ceil(value.count * 100 / res.summ) + '%;"></div></div>');
                    })
                  
                })
            },
            error: function() {
              submited = false;
            }
        });
    }
});
JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>
