<?php
/**
 * Created by PhpStorm.
 * User: Posi_
 * Date: 16.02.2019
 * Time: 19:53
 */

namespace frontend\controllers;


use common\models\tables\TaskProject;
use common\models\tables\Tasks;
use common\models\tables\TeamProject;
use common\models\tables\Teams;
use common\models\tables\Users;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class ProjectController extends Controller
{
    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => TaskProject::find()]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);

    }

    public function actionCreate()
    {
        $model = new TaskProject();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'usersList' => Users::getUsersList(),
        ]);
    }

    public function actionParticipant($id)
    {
        return $this->render('participant', [
            'model' => TaskProject::findOne($id),
            'teamList'=>Teams::getTeamList()
        ]);
    }

    public function actionSave($id)
    {
        $team = Yii::$app->request->post('TaskProject');
        if ($model = TaskProject::findOne($id)) {
//           var_dump($team['id_team']);
            $model->id_team = $team['id_team'];
            $model->save();
            Yii::$app->session->setFlash('success', "Изменения сохранены");
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось сохранить измнения');
        }
        $this->redirect(Yii::$app->request->referrer);
    }

    public function actionOne($id)
    {

        $month = Yii::$app->request->get('month');
        $filter = Yii::$app->request->get('filter');


        if ($month) {
            $dataProvider = new ActiveDataProvider([
                'query' => Tasks::find()
                    ->where(['id_project' => $id])
                    ->andWhere(['MONTH(date)' => $month])
            ]);
        } elseif ($filter == 'deadline') {
            $dataProvider = new ActiveDataProvider([
                'query' => Tasks::find()
                    ->where(['id_project' => $id])
                    ->andWhere(['<', 'dedline_date', date('Y-m-d')])
            ]);
        } elseif ($filter == 'last7day') {
            $dataProvider = new ActiveDataProvider([
                'query' => Tasks::find()
                    ->where(['id_project' => $id])
                    ->andWhere('date_complite >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)')
            ]);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => Tasks::find()
                    ->where(['id_project' => $id])
            ]);
        }

        return $this->render('one',
            [
                'dataProvider' => $dataProvider,
                'id'=> $id
            ]
        );
    }
}