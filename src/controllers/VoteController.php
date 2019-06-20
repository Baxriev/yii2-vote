<?php

namespace baxriev\vote\controllers;

use baxriev\vote\models\VoteAnswers;
use Yii;
use baxriev\vote\models\VoteQuestions;
use baxriev\vote\models\VoteQuestionsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VoteQuestionsController implements the CRUD actions for VoteQuestions model.
 */
class VoteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
//            'access' => [
//                'class' => AccessControl::className(), 
//                'rules' => [
//                    [
//                        'actions' => ['signup'],
//                        'allow' => true,
//                        'roles' => ['?'],
//                    ],
//                    [
//                        'actions' => ['logout'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST','GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all VoteQuestions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VoteQuestionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new VoteQuestions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VoteAnswers();
        $question = new VoteQuestions();

        if ($question->load(Yii::$app->request->post())) {
            $answers = Yii::$app->request->post("VoteAnswers");
            if ($question->save()) {
                foreach ($answers['title'] as $title) {
                    $model = new VoteAnswers();
                    $model->questions_id = $question->id;
                    $model->title = $title;
                    $model->save();
                }
            }

            return $this->redirect(['update', 'id' => $question->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'question' => $question
        ]);
    }

    /**
     * Updates an existing VoteQuestions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $question = $this->findModel($id);
        $model = $question->getVoteAnswers()->all();

        if ($question->load(Yii::$app->request->post())) {
            $answers = Yii::$app->request->post("VoteAnswers");
            $question->save();
            foreach ($model as $key){
                $key->title = $answers['title'][$key->id];
                $key->save();
            }
            return $this->redirect(['update', 'id' => $question->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'question' => $question
        ]);
    }

    /**
     * Deletes an existing VoteQuestions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VoteQuestions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VoteQuestions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VoteQuestions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
