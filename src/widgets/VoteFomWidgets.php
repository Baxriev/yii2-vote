<?php
/**
 * Created by PhpStorm.
 * User: OKS
 * Date: 17.06.2019
 * Time: 11:06
 */

namespace baxriev\vote\widgets;

use baxriev\vote\models\VoteAnswers;
use baxriev\vote\models\VoteQuestions;
use baxriev\vote\models\VoteResult;
use oks\langs\components\Lang;

/**
 * Class VoteFomWidgets
 * @package baxriev\vote\widgets
 */
class VoteFomWidgets extends \yii\base\Widget
{
    /**
     * @return string
     */
    public function run()
    {
        $votes = VoteQuestions::find()->where(['status' => 1, 'lang' => Lang::getLangId()])->all();
        $num = rand(0, count($votes) - 1);
        $vote = $votes[$num];
        if (\Yii::$app->request->cookies->has('voted_ids')){
            $voted_ids = \Yii::$app->request->cookies->getValue('voted_ids');
            $voted_ids = explode(',', $voted_ids);
            $id = $vote['id'];
            if (in_array($id, $voted_ids)){
                $allAnswers = VoteAnswers::find()->where(['questions_id' => $id])->all();

                foreach($allAnswers as $ans) {
                    $count = VoteResult::find()->where(['questions_id'=> $id, 'answer_id'=> $ans->id])->count();
                    $dataToResponse[] = array("answer" => $ans['title'], "count" => $count);
                    $summ[] = $count;
                }

                return $this->render('vote_form',[
                    'dataToResponse' => $dataToResponse,
                    'summ' => $summ,
                    'answer' => $vote
                ]);
            }
        };

        $answers = !empty($vote) ? $vote->getVoteAnswers()->all() : '';

        return $this->render('vote_form',[
            'vote' => $vote,
            'answers' => $answers
        ]);
         
    }

}

