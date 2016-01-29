<?php

namespace app\modules\qa\controllers;

use artkost\qa\controllers\DefaultController as BaseQaDefaultController;
use app\modules\qa\models\QaUser;
use app\modules\qa\models\Answer;
use app\modules\qa\models\Question;
use app\modules\qa\models\QuestionSearch;
use artkost\qa\Module;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception as DbException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DefaultController extends BaseQaDefaultController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'get' => ['tag-suggest'],
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view',
                            'ask',
                            'answer',
                            'unanswered',
                            'answered',
                        ],
                        'roles' => ['?', '@']
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'ask',
                            'answer',
                            'unanswered',
                            'answered',
                        ],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false
                    ]
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $models = $dataProvider->getModels();

        return $this->render('index', compact('searchModel', 'models', 'dataProvider'));
    }

    /**
     * @return string
     */
    public function actionUnanswered()
    {
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->searchUnanswered(Yii::$app->request->getQueryParams());
        $models = $dataProvider->getModels();

        return $this->render('index', compact('searchModel', 'models', 'dataProvider'));
    }

    /**
     * @return string
     */
    public function actionAnswered()
    {
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->searchAnswered(Yii::$app->request->getQueryParams());
        $models = $dataProvider->getModels();

        return $this->render('index', compact('searchModel', 'models', 'dataProvider'));
    }

    /**
     * @return string|Response
     * @throws DbException
     */
    public function actionAsk()
    {
        $model = new Question();
        $userModel = new QaUser();

        if ($model->load($_POST) && $userModel->load($_POST)) {

            $valid=$model->validate();
            $valid=$userModel->validate() && $valid;

            if(!$valid){
                return $this->render('ask', compact(['model', 'userModel']));
            }

            if (!$model->save()) {
                throw new DbException(Module::t('main', 'Error create question'));
            }

            if (!$userModel->save()) {
                throw new DbException(Module::t('main', 'Error save username'));
            }
            $model->user_id = $userModel->id;
            if(!$model->save()){
                throw new DbException(Module::t('main', 'Error saving user id'));
            }

            Yii::$app->session->setFlash('questionFormSubmitted');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('ask', compact(['model', 'userModel']));
        }
    }

    /**
     * @param $id
     * @throws NotFoundHttpException
     * @return string
     */
    public function actionView($id)
    {
        /** @var Question $model */
        $model = Question::find()->with('user')->where(['id' => $id])->one();
        $userModel = new QaUser();

        if ($model) {

            if ($model->isUserUnique()) {
                $model->updateCounters(['views' => 1]);
            }

            $answer = new Answer;

            $query = Answer::find()->with('user');

            $answerOrder = Answer::applyOrder($query, Yii::$app->request->get('answers', 'votes'));

            $answerDataProvider = new ActiveDataProvider([
                'query' => $query->where(['question_id' => $model->id]),
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);

            return $this->render('view', compact('model', 'answer', 'answerDataProvider', 'answerOrder', 'userModel'));
        } else {
            $this->notFoundException();
        }
    }

    /**
     * @param $id
     * @return string|Response
     */
    public function actionAnswer($id)
    {
        $name = '';
        if(isset($_POST['QaUser']['username']))
            $name = $_POST['QaUser']['username'];
        $model = new Answer(['question_id' => $id]);
        $userModel = new QaUser();

        /** @var Question $question */
        $question = $model->question;

        if (!$question)
            $this->notFoundException();

        if ($model->load($_POST) && $userModel->load($_POST)) {

            $valid = $model->validate();
            $valid = $userModel->validate() && $valid;

            if (!$valid)
                return $this->render('answer', compact(['model', 'question', 'userModel', ]));
        }

        $user = $userModel->find()->where(['username'=>$name])->one();
        if(!$user)
            $user = $userModel->createUser($name);

        if ($model->load($_POST))
            $model->user_id = $user->id;

        if ($model->save()) {
            Yii::$app->session->setFlash('answerFormSubmitted');
            return $this->redirect(['view', 'id' => $question->id, 'alias' => $question->alias]);
        } else {
            return $this->render('answer', compact('model', 'question', 'userModel'));
        }
    }
}