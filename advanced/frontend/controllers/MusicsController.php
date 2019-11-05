<?php

namespace frontend\controllers;

use Yii;
use frontend\models\User;
use frontend\models\Profile;
use frontend\models\ProfileHasMusics;
use frontend\models\Genres;
use frontend\models\Musics;
use frontend\models\SearchMusics;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\BaseVarDumper;

/**
 * MusicsController implements the CRUD actions for Musics model.
 */
class MusicsController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Musics models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchMusics();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Musics model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Musics model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $currentProfile = $this->getCurrentProfile();

        if($currentProfile->isprodutor == 'N' || is_null($currentProfile->isprodutor)){
            return $this->redirect(['index']);
        }


        $model = new Musics();
        $modelGenres = Genres::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $model->launchdate = date("Y/m/d");
            $model->save();

            //ESTA MERDA NÃO FUNCIOOOOOOOOOOOOOONAAAAAAAAAAAAAAAAAAA
                BaseVarDumper::dump($model);
                ?>
                <br><br><br><br>
                <?php
                $currentUser = $this->getCurrentUser();
                $profileHasMusics = new ProfileHasMusics();
                $profileHasMusics->profile_id = $currentUser->id;
                BaseVarDumper::dump($profileHasMusics->profile_id);
                ?>
                <br><br><br><br>
                <?php
                $profileHasMusics->musics_id = $model->id;
                BaseVarDumper::dump($profileHasMusics->musics_id);
                ?>
                <br><br><br><br>
                <?php
                if($profileHasMusics->validate()){
                    $profileHasMusics->save(); 
                    
                    BaseVarDumper::dump("\n\n\n\n\nBYEBYE");
                }
                else{

                    BaseVarDumper::dump($profileHasMusics);
                }
                die();

            return $this->redirect(['user/index']);
        }

        return $this->render('create', [
            'model' => $model,
            'modelGenres' => $modelGenres,
        ]);
    }



    private function getCurrentUser(){
        $profileProvider = Profile::find()->where(['id_user' => Yii::$app->user->id])->one();
        $userProvider = User::find()->where(['id'=>Yii::$app->user->id])->one();
        return $userProvider;
    }

    private function getCurrentProfile(){
        $profileProvider = Profile::find()->where(['id_user' => Yii::$app->user->id])->one();
        return $profileProvider;
    }






    private function getMusicsFromProfile(){
        $profile = $this->getCurrentProfile();
        $ProfileHasMusics = ProfileHasMusics::find()->where(['profile_id' => Yii::$app->user->id])->all();
    }





    /**
     * Updates an existing Musics model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Musics model.
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
     * Finds the Musics model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Musics the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Musics::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
