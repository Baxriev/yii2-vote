<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\VoteQuestions */
/* @var $form yii\widgets\ActiveForm */
$script = <<<JS
$(document).ready(function() {

    var MaxInputs       = 8; //Número Maximo de Campos
    var contenedor       = $("#contenedor"); //ID del contenedor
    var AddButton       = $("#agregarCampo"); //ID del Botón Agregar

    //var x = número de campos existentes en el contenedor
    var x = $("#contenedor div").length + 1;
    var FieldCount = x-1; //para el seguimiento de los campos

    $(AddButton).click(function (e) {
        if(x <= MaxInputs) //max input box allowed
        {
            FieldCount++;
            //agregar campo
            $(contenedor).append('<div><input class="title-generate form-control" type="text" name="VoteAnswers[title]['+ FieldCount +']" id="campo_'+ FieldCount +'" placeholder="Ответ '+ FieldCount +'"/><a href="#" class="eliminar">&times;</a></div>');
            x++; //text box increment
        }
        return false;
    });

    $("body").on("click",".eliminar", function(e){ //click en eliminar campo
        if( x > 1 ) {
            $(this).parent('div').remove(); //eliminar el campo
            x--;
        }
        return false;
    });
});

JS;
$this->registerJs($script);
?>

<style>
    a {
        text-decoration: none;
    }
    .btn {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        border-image: none;
        border-radius: 4px 4px 4px 4px;
        border-style: solid;
        border-width: 1px;
        box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
        cursor: pointer;
        display: inline-block;
        font-size: 14px;
        line-height: 20px;
        margin-bottom: 10px;
        margin-top: 10px;
        padding: 4px 12px;
        text-align: center;
        vertical-align: middle;
    }
    .btn-info {
        background-color: #49AFCD;
        background-image: linear-gradient(to bottom, #5BC0DE, #2F96B4);
        background-repeat: repeat-x;
        border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
        color: #FFFFFF;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }
    .btn:hover{
        color:#333;
        text-decoration:none;
        background-position:0 -15px;
        -webkit-transition:background-position .1s linear;
        -moz-transition:background-position .1s linear;
        -o-transition:background-position .1s linear;
        transition:background-position .1s linear;
    }
    .btn-info:hover{
        color:#fff;
        background-color:#2f96b4;
    }
    #contenedor {
        margin-top: 15px;
    }
    .eliminar {
        margin: 5px;
    }
    .title-generate {
        width: 90%;
        float: left;
        margin-bottom: 2px;
    }
    .eliminar {
        font-size: 25px;
    }
</style>
<div class="vote-answers-form col-lg-12">
    <?php $form = ActiveForm::begin(); ?>
    <div class="panel form-horizontal col-md-6">
        <div class="panel-body">
            <?=$form->field($question, 'title')->textInput()?>

            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <?php
                    if (is_null($question->status)) {
                        $question->status = true;
                    }
                    // Usage with ActiveForm and model
                    echo $form->field($question, 'status')->checkbox(['data-init-plugin' => 'switchery']);
                    ?>
                </div>
                <?
                echo $form->field($question, 'top')->checkbox(['data-init-plugin' => 'switchery']);
                ?>
            </div>
            <div class="form-group col-lg-12">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <div class="panel form-horizontal col-md-6">
        <div class="panel-body">
            <div id="contenedor">
                <?php if (!empty($model[0])) : ?>
                    <?php $i = 1; foreach ($model as $item) : ?>
                        <div class="added">
                            <input class="title-generate form-control" type="text" value="<?=$item['title']?>" name="VoteAnswers[title][<?=$i++;?>]" id="input_<?=$i;?>"/><a href="#" class="eliminar">&times;</a>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="added">
                        <input class="title-generate form-control" type="text" name="VoteAnswers[title][]" id="input_1" placeholder="<?=__('Ответ')?> 1"/><a href="#" class="eliminar">&times;</a>
                    </div>
                <?php endif; ?>
            </div>
            <a id="agregarCampo" class="btn btn-info" href="#"><?=__('Добавить')?></a>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
