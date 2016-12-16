<?php

namespace backend\controllers;

use common\models\Contact;
use common\models\ContactDetail;
use common\models\Mark;
use common\models\MarkSearch;
use common\models\Subject;
use PHPExcel_IOFactory;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * MarkController implements the CRUD actions for Mark model.
 */
class MarkController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Mark models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Mark();
        if ($model->load(Yii::$app->request->get())) {
            //var_dump($model);
        }
        $searchModel = new MarkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mark model.
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
     * Finds the Mark model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mark the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mark::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Mark model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mark();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Mark model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Mark model.
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
     * @return string
     */
    public function actionUpload()
    {

        $model = new Mark();
        $check = 0;

        $post = Yii::$app->request->post();

        // download template
        if ($model->load($post) && strcmp($model->action, "download") == 0) {
            $this->downloadTemplate($model);
            $model->setScenario('admin_create_update');
            return $this->render('upload', [
                'model' => $model,
            ]);
        }

        if (Yii::$app->request->isAjax && isset($post['ajax']) && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load($post)) {

            $file_download = UploadedFile::getInstance($model, 'file');

            if ($file_download) {

                $file_name = Yii::$app->user->id . '.' . uniqid() . time() . '.' . $file_download->extension;
                $tmp = Yii::getAlias('@backend') . '/web/' . Yii::getAlias('@file_downloads') . '/';

                if (!file_exists($tmp)) {
                    mkdir($tmp, 0777, true);
                }

                if ($file_download->saveAs($tmp . $file_name)) {
                    $model->file = $file_name;
                }

                try {
                    $inputFileType = \PHPExcel_IOFactory::identify($tmp . $file_name);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($tmp . $file_name);
                    $sheets = $objPHPExcel->getAllSheets();

                    foreach ($sheets as $item) {

                        $highestRow = $item->getHighestRow();
                        $highestColumn = $item->getHighestColumn();

                        echo $highestRow. ' '.$highestColumn;

                        for ($row = 11; $row <= $highestRow; $row++) {

                            $rowData = $item->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);

                            $mark = Mark::findOne(['student_id' => $rowData[0][2], 'subject_id' => $rowData[0][1], 'class_id' => $model->class_id, 'semester' => $model->semester]);

                            if (is_null($mark)) {
                                $mark = new Mark();
                                $mark->created_at = time();
                                $mark->created_by = Yii::$app->user->id;
                                $mark->student_id = $rowData[0][2];
                                $mark->subject_id = intval($rowData[0][1]);
                                $mark->class_id = $model->class_id;
                                $mark->semester = $model->semester;
                            } else {
                                $mark->updated_at = time();
                                $mark->updated_by = Yii::$app->user->id;
                            }

                            // set marks
                            $mark_str = '';
                            for ($i = 4; $i < ord($highestColumn) - ord('A'); $i++) {
                                if (is_null($rowData[0][$i])) {
                                    $mark_str = $mark_str . 'N;';
                                } else {
                                    $mark_str = $mark_str . $rowData[0][$i] . ';';
                                }
                            }
                            $mark->marks = $mark_str;

                            if ($mark->save(false)) {
                                $check = 1;
                            }
                        }
                    }

                    if ($check) {
                        Yii::$app->getSession()->setFlash('success', 'Upload thành công');
                        return $this->redirect(['index']);
                    } else {
                        Yii::$app->getSession()->setFlash('error', 'Upload không thành công');
                    }
                } catch (Exception $ex) {
                }
            } else {
                Yii::$app->getSession()->setFlash('error', 'Bạn chưa chọn file tải mẫu để upload');
                return $this->render('upload', [
                    'model' => $model,
                ]);
            }
        }
    }

//    public function check(){
//        $mark = Mark::findOne(['student_id' => '1', 'subject_id'=>'9','class_id'=>'1', 'semester'=>'1']);
//        var_dump($mark);
//    }

    /**
     *
     */
    public function downloadTemplate($model)
    {

        $file_name = 'Mark_Upload.xls';
        $tmp = Yii::getAlias('@backend') . '/web/' . Yii::getAlias('@file_template') . '/';
        $file = $tmp . $file_name;

        if (file_exists($file)) {

            try {

                $inputFileType = \PHPExcel_IOFactory::identify($tmp . $file_name);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($tmp . $file_name);
                $sheet = clone $objPHPExcel->getSheet(0);
                $objPHPExcel->removeSheetByIndex(0);

                if (!is_array($model->subject_id)) {
                    Yii::$app->getSession()->setFlash('error', 'Bạn chưa chọn môn học để tải file mẫu');
                    return;
                }

                for ($i = 0; $i < count($model->subject_id); $i++) {

                    $sheet_ = clone $sheet;

                    $subject = Subject::findOne($model->subject_id[$i]);
                    $class = Contact::findOne($model->class_id);
                    $students = ContactDetail::find()->where(['contact_id' => $model->class_id])->all();

                    // set school
                    $title_ = $sheet_->getCell('A2')->getValue();
                    $sheet_->setCellValue('A2', str_replace("[school]", "CVA3", $title_));

                    // set subject
                    $year = date("Y") . '-' . (intval(date("Y")) + 1);
                    $title_ = $sheet_->getCell('A3')->getValue();
                    $sheet_->setCellValue('A3', $title_ = str_replace("[subject]", $subject->name, $title_));
                    $sheet_->setCellValue('A3', $title_ = str_replace("[class]", $class->contact_name, $title_));
                    $sheet_->setCellValue('A3', $title_ = str_replace("[semester]", $model->semester = '1' ? "1" : "2", $title_));
                    $sheet_->setCellValue('A3', $title_ = str_replace("[year]", $year, $title_));

                    // set sheet name
                    $title_ = $sheet->getTitle();
                    $sheet_->setTitle($title_ = str_replace("subject", $subject->name, $title_));
                    $sheet_->setTitle($title_ = str_replace("class", $class->contact_name, $title_));

                    $row = 1;
                    foreach ($students as $item) {
                        $sheet_->setCellValue('A' . ($row + 10), $row);
                        $sheet_->setCellValue('B' . ($row + 10), $subject->id);
                        $sheet_->setCellValue('C' . ($row + 10), $item->id);
                        $sheet_->setCellValue('D' . ($row + 10), $item->fullname);
                        $row++;
                    }
                    $objPHPExcel->addSheet($sheet_);
                }

                // set file name upload
                $file_name_upload = "Điểm_";
                if (is_array($model->subject_id) && count($model->subject_id) == 1) {
                    $file_name_upload = $file_name_upload . $subject->name . "_";
                }
                $file_name_upload = $file_name_upload . $class->contact_name . "_";
                $file_name_upload = $file_name_upload . ($model->semester = '1' ? "HK1_" : "HK2_");
                $file_name_upload = $file_name_upload . $year;
                $file_name_upload = $file_name_upload . "_Upload.xls";


                header("Content-Length: " . filesize($file));
                header("Content-type: application/octet-stream");
                header("Content-disposition: attachment; filename=" . basename($file_name_upload));
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                ob_clean();
                flush();

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');

            } catch (Exception $ex) {
            }
        } else {
            Yii::$app->getSession()->setFlash('error', 'File is not exits');
        }
    }

    /**
     *
     */
    public function actionViewUpload()
    {
        $model = new Mark();
        $model->setScenario('admin_create_update');
        return $this->render('upload', [
            'model' => $model,
        ]);
    }
}
