<?php

namespace backend\controllers;

use common\models\ContactSearch_;
use kartik\widgets\ActiveForm;
use Yii;
use common\models\Contact;
use common\models\ContactSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends BaseBEController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
//            [
//                'class' => ActionLogTracking::className(),
//                'user' => Yii::$app->user,
//                'model_type_default' => UserActivity::ACTION_TARGET_TYPE_CONTENT,
//            ],
        ]);
    }

    /**
     * Lists all Contact models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContactSearch();
        $searchModel1 = new ContactSearch_();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,null);
        $dataProviderClass = $searchModel1->search(Yii::$app->request->queryParams,1);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'searchModel1' => $searchModel1,
            'dataProvider' => $dataProvider,
            'dataProviderClass' => $dataProviderClass,
        ]);
    }

    /**
     * Displays a single Contact model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Contact model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type = null)
    {
        $model = new Contact();
        $model->setScenario('admin_create_update');
        $post = Yii::$app->request->post();
        if (Yii::$app->request->isAjax && isset($post['ajax']) && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = time();
            $model->updated_at = time();
            $model->created_by = Yii::$app->user->id;
            if (!$model->save()) {
                Yii::$app->session->setFlash('error', 'Thêm danh bạ không thành công');
                if($type){
                    return $this->render('_create', [
                        'model' => $model,
                    ]);
                }else{
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }

            }
            Yii::$app->session->setFlash('success', 'Thêm danh bạ thành công');
            return $this->redirect(['index']);
        } else {
            if($type){
                return $this->render('_create', [
                    'model' => $model,
                ]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing Contact model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $type = $model->path;
        $model->setScenario('admin_create_update');
        $post = Yii::$app->request->post();
        if (Yii::$app->request->isAjax && isset($post['ajax']) && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = time();
            if (!$model->save()) {
                Yii::$app->session->setFlash('error', 'Cập nhật danh bạ không thành công');
                if($type){
                    return $this->render('_update', [
                        'model' => $model,
                    ]);
                }else{
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
            }
            Yii::$app->session->setFlash('success', 'Cập nhật danh bạ thành công');
            return $this->redirect(['index']);
        } else {
            if($type){
                return $this->render('_update', [
                    'model' => $model,
                ]);
            }else{
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

        }
    }

    /**
     * Deletes an existing Contact model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Contact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contact::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
