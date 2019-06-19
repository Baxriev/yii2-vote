<?php
/**
 * Created by PhpStorm.
 * User: OKS
 * Date: 17.06.2019
 * Time: 15:49
 */

namespace baxriev\vote\controllers;

use baxriev\vote\models\VoteAnswers;
use baxriev\vote\models\VoteResult;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Cookie;

class VoteResultController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'result' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionResult()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new VoteResult();
        if ($data = Yii::$app->request->post()) {
            $model->answer_id = $data['answer_id'];
            $model->questions_id = $data['questions_id'];

            if ($model->save()) {
                $allAnswers = VoteAnswers::find()->andWhere(['questions_id' => $data['questions_id']])->all();

                foreach ($allAnswers as $ans) {
                    $count = VoteResult::find()->andWhere(['questions_id' => $data['questions_id'], 'answer_id' => $ans->id])->count();
                    $dataToResponse[] = array("answer" => $ans['title'], "count" => $count);
                    $summ[] = $count;
                }

                if (Yii::$app->request->cookies->has('voted_ids')) {
                    $voted_ids = Yii::$app->request->cookies->getValue('voted_ids');
                    $voted_ids .= "," . $model->questions_id;
                    Yii::$app->response->cookies->add(new Cookie(['name' => 'voted_ids', 'value' => $voted_ids]));

                    return ['dataToResponse' => $dataToResponse, 'summ' => array_sum($summ)];
                }

                Yii::$app->response->cookies->add(new Cookie(['name' => 'voted_ids', 'value' => $model->questions_id]));
                return ['dataToResponse' => $dataToResponse, 'summ' => array_sum($summ)];
                
            }
        }
    }
}