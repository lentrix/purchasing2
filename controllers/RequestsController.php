<?php

namespace app\controllers;

use yii;
use app\models\Users;
use app\models\Requests;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;

class RequestsController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access'=>[
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className()
                ],
                'only' => [
                    'create',
                    'populateRequest',
                    'finish-request',
                    'view',
                    'cancel',
                    'remove-item',
                    'approve',
                    'deny'
                ],
                'rules' => [
                    [
                        'actions' => ['create','populateRequest',
                            'finish-request','view','cancel','remove-item'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['approve','deny'],
                        'allow'=>true,
                        'roles' => [Users::ROLE_DEPARTMENT_HEAD, Users::ROLE_ADMIN],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'cancel' => ['POST'],
                    'removeItem' => ['POST'],
                    'approve' => ['POST'],
                    'deny' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $request = new Requests();
        $request->date = date('Y-m-d');
        $request->status = Requests::STATUS_PENDING;
        $request->requested_by = Yii::$app->user->id;
        $request->save();

        return $this->redirect(['/requests/populate-request','id'=>$request->id]);
    }

    public function actionPopulateRequest($id)
    {
        $request = Requests::findOne($id);
        $requestItem = new \app\models\RequestItems;
        $requestItem->request_id = $id;

        if($requestItem->load(Yii::$app->request->post()) && $requestItem->validate()) {
            $requestItem->save();
            $requestItem = new \app\models\RequestItems;
            $requestItem->request_id = $id;
        }

        return $this->render('create', compact('request','requestItem'));
    }

    public function actionFinishRequest($id)
    {
        $request = Requests::find()->where(['id'=>$id])->with('requestedBy')->one();
        Yii::$app->session->setFlash('success','The request has been made.');
        
        return $this->redirect(['/site/index']);
    }

    public function actionView($id)
    {
        $request = Requests::findOne($id);
        if(!$request) {
            throw new \yii\web\NotFoundHttpException('Request not found. It may have been cancelled by the requesting party.');
        }
        return $this->render('view', compact('request'));
    }

    public function actionCancel($id) {
        $request = Requests::findOne($id);
        $request->delete();
        
        Yii::$app->session->setFlash('warning','The request has been cancelled.');
        return $this->redirect(['/site/index']);
    }

    public function actionRemoveItem($item_id) {
        $requestItem = \app\models\RequestItems::findOne($item_id);
        $requestId = $requestItem->request_id;
        $requestItem->delete();
        return $this->redirect(['/requests/populate-request','id'=>$requestId]);
    }

    public function actionApprove($id)
    {
        $request = Requests::findOne($id);
        $request->status=Requests::STATUS_APPROVED;
        $request->approved_by = Yii::$app->user->id;
        $request->save();
        return $this->redirect(['/site/index']);
    }

    public function actionIndex()
    {
        $searchModel = new \app\models\RequestsSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', compact('searchModel','dataProvider'));
    }

    public function actionDeny($id) {
        $request = Requests::findOne($id);
        $request->status = Requests::STATUS_DENIED;
        $request->approved_by = Yii::$app->user->id;
        $request->save();
        Yii::$app->session->setFlash('warning','A request has been denied.');
        return $this->redirect(['/site/index']);
    }
}
