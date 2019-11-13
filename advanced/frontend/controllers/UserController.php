<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Musics;
use frontend\models\User;
use frontend\models\SearchUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Profile;
use frontend\models\SearchProfile;
use frontend\models\ProfileHasMusics;
use yii\helpers\BaseVarDumper;
use frontend\models\Venda;
use frontend\models\Linhavenda;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    // /**
    //  * {@inheritdoc}
    //  */
    // public function behaviors()
    // {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['POST'],
    //             ],
    //         ],
    //     ];
    // }

    // /**
    //  * Lists all User models.
    //  * @return mixed
    //  */
    // public function actionIndex()
    // {
    //     $searchModel = new SearchUser();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    // /**
    //  * Displays a single User model.
    //  * @param integer $id
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    // /**
    //  * Creates a new User model.
    //  * If creation is successful, the browser will be redirected to the 'view' page.
    //  * @return mixed
    //  */
    // public function actionCreate()
    // {
    //     $model = new User();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Updates an existing User model.
    //  * If update is successful, the browser will be redirected to the 'view' page.
    //  * @param integer $id
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Deletes an existing User model.
    //  * If deletion is successful, the browser will be redirected to the 'index' page.
    //  * @param integer $id
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    public function getCurrentUser(){
        return User::find()->where(['id'=>Yii::$app->user->id])->one();
    }

    public function getCurrentProfile(){
        return Profile::find()->where(['id_user' => Yii::$app->user->id])->one();
    }

    public function countHowManyMusicsProducerHas(){
        return count(ProfileHasMusics::find()->where(['profile_id' => Yii::$app->user->id])->all());
    }

    //BUSCA A LISTA DE MUSICAS DO PRODUTOR
    private function getProducerMusicsIds(){
        $profile = $this->getCurrentProfile();
        $user = $this->getCurrentUser();
        $ProfileHasMusics = ProfileHasMusics::find()->where(['profile_id' => $user->id])->all();
        $musicas[] = null;
        foreach ($ProfileHasMusics as $music ) {
            array_push($musicas, $music->musics_id);
        }
        return $musicas;
    }
    public function getProducerMusics(){
        $arrayDeMusicasIds[] = $this->getProducerMusicsIds();
        $arrayDeMusicas = null;
        foreach ($arrayDeMusicasIds as $idDaMusica) {
            $arrayDeMusicas = Musics::find()->where(['id' => $idDaMusica])->all();
        }
        return $arrayDeMusicas;
    }



    public function countHowManyAlbumsProducerHas(){
        return count(ProfileHasAlbums::find()->where(['profile_id' => Yii::$app->user->id])->all());
    }

    private function getProducerAlbumsIds(){
        $profile = $this->getCurrentProfile();
        $ProfileHasAlbums = ProfileHasAlbums::find()->where(['profile_id' => $profile->id_user])->all();
        $albums[] = null;
        foreach ($ProfileHasAlbums as $album ) {
            array_push($albums, $album->albums_id);
        }
        return $albums;
    }
    public function getProducerAlbums(){
        $arrayDeAlbumsIds[] = $this->getProducerAlbumsIds();
        $arrayDeAlbums = null;
        foreach ($arrayDeAlbumsIds as $idDoAlbum) {
            $arrayDeAlbums = Albums::find()->where(['id' => $idDoAlbum])->all();
        }
        return $arrayDeAlbums;
    }



    public function getVendasUserLogado(){
        $profile = $this->getCurrentProfile();
        $vendaDoUserLogado = Venda::find()->where(['profile_id' => $profile->id])->all();
        
        return $vendaDoUserLogado;
    }
    

    public function getLinhavendaUserLogado(){
        $arrayVendasIds = $this->getVendasUserLogado();

        // BaseVarDumper::dump($arrayVendasIds);

        // die();

        $LinhavendaUserLogado = [];
        array_filter($LinhavendaUserLogado);

        foreach ($arrayVendasIds as $venda) {
            array_push($LinhavendaUserLogado, Linhavenda::find()->where(['venda_id' => $venda->id ])->one());
        }


        // BaseVarDumper::dump($LinhavendaUserLogado);

        // die();

        return $LinhavendaUserLogado;
    }


    public function getMusicasPelasLinhaDeVendaDoUserLogado(){
        
        $LinhavendaDoUser = $this->getLinhavendaUserLogado();
        $musicasCompradasPeloUser = [];

        for ($i=0; $i < count($LinhavendaDoUser); $i++) { 
            array_push($musicasCompradasPeloUser, Musics::find()->where(['id' => $LinhavendaDoUser[$i]->musics_id])->one());
        }

        return $musicasCompradasPeloUser;

    }

    public function getMusicasPelasLinhaDeVendaDoUserLogadoTesteMeterNomeProdutorNaMusica(){
        
        $musicasCompradasPeloUser = $this->getMusicasPelasLinhaDeVendaDoUserLogado();

        $profileHasMusics = ProfileHasMusics::find()->all();

        $arrayComTodasAsMusicas = [];
        array_filter($arrayComTodasAsMusicas);

        foreach ($profileHasMusics as $phm) {
            $criadorDestaMusica = User::find()->where(['id' => $phm->profile_id])->one();
            $musicaDesteProfile = Musics::find()->where(['id' => $phm->musics_id])->one();
            $musicaDesteProfile->producerOfThisSong = $criadorDestaMusica->username;
            array_push($arrayComTodasAsMusicas, $musicaDesteProfile);
        }       
        if(!is_null($musicasCompradasPeloUser) && !empty($musicasCompradasPeloUser)) {
            for ($l=0; $l < count($musicasCompradasPeloUser); $l++) { 
                
                for ($i = 0; $i < count($arrayComTodasAsMusicas); $i++) {
                    if($musicasCompradasPeloUser[$l]->id === $arrayComTodasAsMusicas[$i]->id){
                        $musicasCompradasPeloUser[$l]->producerOfThisSong = $arrayComTodasAsMusicas[$i]->producerOfThisSong;
                    }
                }
            }
            return $musicasCompradasPeloUser;
        }
        else{
            return null;
        }
    }



    public function actionIndex()
    {


        $profileProvider = $this->getCurrentProfile();

        $userProvider = $this->getCurrentUser();

        $numberOfSongsYouHave = $this->countHowManyMusicsProducerHas();



        $arrayComAsTuasMusicas = $this->getProducerMusics();

        $musicasCompradasPeloUserObjeto_UsarEmForeach = $this->getMusicasPelasLinhaDeVendaDoUserLogadoTesteMeterNomeProdutorNaMusica();


        if(is_null($musicasCompradasPeloUserObjeto_UsarEmForeach)){
            return $this->render('index', ['userProvider' => $userProvider, 'profileProvider' => $profileProvider, 'numberOfSongsYouHave' => $numberOfSongsYouHave, 'arrayComAsTuasMusicas' => $arrayComAsTuasMusicas] );
        }else{

            return $this->render('index', ['userProvider' => $userProvider, 'profileProvider' => $profileProvider, 'numberOfSongsYouHave' => $numberOfSongsYouHave, 'arrayComAsTuasMusicas' => $arrayComAsTuasMusicas, 'musicasCompradasPeloUserObjeto_UsarEmForeach' => $musicasCompradasPeloUserObjeto_UsarEmForeach] );
        }
    }

    public function actionSettings(){

        $profileProvider = $this->getCurrentProfile();
        $userProvider = $this->getCurrentUser();
        //$userProvider = Yii::$app->user;
        return $this->render('settings', ['userProvider' => $userProvider, 'profileProvider' => $profileProvider]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
