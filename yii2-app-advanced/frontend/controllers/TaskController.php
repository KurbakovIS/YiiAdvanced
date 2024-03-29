<?php
/**
 * Created by PhpStorm.
 * User: Posi_
 * Date: 18.12.2018
 * Time: 15:46
 */

namespace frontend\controllers;


use common\models\tables\TaskProject;
use frontend\models\forms\TaskAttachmentsAddForm;
use common\models\tables\TaskComments;
use common\models\tables\Tasks;
use common\models\tables\TaskStatus;
use common\models\tables\Users;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\UploadedFile;

class TaskController extends Controller
{

    public function actionIndex()
    {

        $month = Yii::$app->request->get('month');
        $filter = Yii::$app->request->get('filter');
        if ($month) {
            $dataProvider = new ActiveDataProvider([
                'query' => Tasks::find()
                    ->where(['MONTH(date)' => $month])
            ]);
        } elseif ($filter == 'deadline') {
            $dataProvider = new ActiveDataProvider([
                'query' => Tasks::find()
                    ->where(['<', 'dedline_date', date('Y-m-d')])
            ]);
        }elseif ($filter == 'last7day') {
            $dataProvider = new ActiveDataProvider([
                'query' => Tasks::find()
                    ->where('date_complite >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)')
            ]);
        }  else {
            $dataProvider = new ActiveDataProvider([
                'query' => Tasks::find()
            ]);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);

    }

    public function actionOne($id)
    {
        return $this->render('one', [
            'model' => Tasks::findOne($id),
            'userList' => Users::getUsersList(),
            'statusesList' => TaskStatus::getList(),
            'userId' => Yii::$app->user->id,
            'taskComments' => new TaskComments(),
            'taskAttachmentForm' => new TaskAttachmentsAddForm(),
        ]);
    }

    public function actionCreate()
    {
        $model = new Tasks();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['project/index']);
        }

        return $this->render('create', [
            'model' => $model,
            'usersList' => Users::getUsersList(),
            'projectsList' => TaskProject::getProjectList(),
            'administrator' => Users::getUsersList(),
        ]);
    }

    public function actionSave($id)
    {
        if ($model = Tasks::findOne($id)) {
            $model->load(Yii::$app->request->post());
            if ($model->status == 3) {
                $model->date_complite = date('Y-m-d');
            } else {
                $model->date_complite = NULL;
            }
            $model->save();
            Yii::$app->session->setFlash('success', "Изменения сохранены");
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось сохранить измнения');
        }
        $this->redirect(Yii::$app->request->referrer);
    }

    public function actionAddComment($id)
    {
        $model = new TaskComments();
        $request = Yii::$app->request;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "комментарий добавлен");
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось добавить комментарий');
        }
        return $this->render('one', [
            'model' => Tasks::findOne($id),
            'userList' => Users::getUsersList(),
            'statusesList' => TaskStatus::getList(),
            'userId' => Yii::$app->user->id,
            'taskComments' => new TaskComments(),
            'taskAttachmentForm' => new TaskAttachmentsAddForm(),
        ]);
    }

    public function actionAddAttachment()
    {
        $model = new TaskAttachmentsAddForm();
        $model->load(Yii::$app->request->post());
        $model->file = UploadedFile::getInstance($model, 'file');
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Файл добавлен');
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось сохранить файл');
        }
        $this->redirect(Yii::$app->request->referrer);
    }
}