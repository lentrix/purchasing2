<?php

namespace app\controllers;

use yii;
use yii\base\Model;
use app\models\Users;
use app\models\Requests;
use app\models\PurchaseOrders;
use app\models\PurchaseOrderItems;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;

class PurchaseOrdersController extends \yii\web\Controller
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
                    'update',
                    'items',
                    'view',
                    'delete',
                    'add-item',
                    'remove-item',
                    'change-status'
                ],
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['create','update','items','delete','add-item','remove-item','change-status'],
                        'allow'=>true,
                        'roles' => [Users::ROLE_ADMIN, Users::ROLE_PURCHASING_OFFICER],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'remove-item' => ['POST'],
                    'change-status' => ['POST'],
                ],
            ],
        ];
    }
    public function actionCreate($request_id)
    {
        $request = Requests::findOne($request_id);
        $po = new PurchaseOrders;
        $po->date = date('Y-m-d');
        $po->request_id = $request->id;
        $po->status = PurchaseOrders::STATUS_ISSUED;

        if($po->load(Yii::$app->request->post()) && $po->save()) {
            //create po items
            foreach($request->requestItems as $rItem) {
                $poItem = new PurchaseOrderItems;
                $poItem->purchaseOrder_id = $po->id;
                $poItem->requestItem_id = $rItem->id;
                $poItem->name = $rItem->name;
                $poItem->quantity = $rItem->quantity;
                $poItem->unit_measurement = $rItem->unit_measurement;
                $poItem->save();
            }
            return $this->redirect(['/purchase-orders/items','id'=>$po->id]);
        }

        return $this->render('create', compact('po','request'));
    }

    public function actionItems($id) {
        $purchaseOrder = PurchaseOrders::findOne($id);
        $orderItems = $purchaseOrder->purchaseOrderItems;

        if(Model::loadMultiple($orderItems, Yii::$app->request->post())) {
            foreach($orderItems as $orderItem) {
                $orderItem->save(false);
            }
            return $this->redirect(['/purchase-orders/view', 'id'=>$purchaseOrder->id]);
        }
        return $this->render('items',compact('purchaseOrder','orderItems'));
    }

    public function actionDelete()
    {
        return $this->render('delete');
    }

    public function actionUpdate()
    {
        return $this->render('update');
    }

    public function actionView($id)
    {
        $model = PurchaseOrders::findOne($id);
        return $this->render('view', compact('model'));
    }

}
