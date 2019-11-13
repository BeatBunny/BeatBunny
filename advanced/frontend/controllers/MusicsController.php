<?php

namespace frontend\controllers;

use Yii;
use frontend\models\User;
use frontend\models\Profile;
use frontend\models\ProfileHasMusics;
use frontend\models\ProfileHasAlbums;
use frontend\models\Genres;
use frontend\models\Albums;
use frontend\models\Musics;
use frontend\models\Iva;
use frontend\models\SearchMusics;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\BaseVarDumper;
use yii\web\UploadedFile;
use frontend\models\Venda;
use frontend\models\Linhavenda;


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

        $allTheMusicsWithProducer = $this->converterMusicasComProducerArrayParaObject();

        $searchModel = new SearchMusics();

        $currentUser = $this->getCurrentUser();

        $currentProfile = $this->getCurrentProfile();

        if(!is_null($currentUser)){
            $musicasCompradasPeloUser = $this->getMusicasPelasLinhaDeVendaDoUserLogadoTesteMeterNomeProdutorNaMusica();
            return $this->render('index', [
                'searchModel' => $searchModel,
                'allTheMusicsWithProducer' => $allTheMusicsWithProducer,
                'currentUser' => $currentUser,
                'musicasCompradasPeloUser' => $musicasCompradasPeloUser,
            ]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'allTheMusicsWithProducer' => $allTheMusicsWithProducer,
            'currentUser' => $currentUser,
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

    

    public function actionBuymusic($id, $producerOfThisSong){
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect('musics/index');
        }

        $currentUser = $this->getCurrentUser();
        $currentProfile = $this->getCurrentProfile();
        $musicasCompradasPeloUser = $this->getMusicasPelasLinhaDeVendaDoUserLogadoTesteMeterNomeProdutorNaMusica();
        if(is_null($musicasCompradasPeloUser)){

            return $this->render('buymusic', [
                'model' => $model,
                'producerOfThisSong' => $producerOfThisSong,
                'currentUser' => $currentUser,
                'currentProfile' => $currentProfile,
            ]);
        }
        else{
            return $this->render('buymusic', [
                'model' => $this->findModel($id),
                'producerOfThisSong' => $producerOfThisSong,
                'currentUser' => $currentUser,
                'currentProfile' => $currentProfile,
                'musicasCompradasPeloUser' => $musicasCompradasPeloUser,
            ]);
        }
    }

    public function actionFinishpayment($id){
        
        $model = $this->findModel($id);
        $currentProfile = $this->getCurrentProfile();
        $currentUser = $this->getCurrentUser();
        
        $currentProfile->saldo = $currentProfile->saldo-$model->pvp;

        $profileHasMusics = new ProfileHasMusics();
        $newVenda = new Venda();

        $newVenda->data = date("Y/m/d");
        $newVenda->valorTotal = $model->pvp;

        $newVenda->profile_id = $currentProfile->id;

        
        $profileHasMusics->musics_id = $model->id;
        $profileHasMusics->profile_id = $currentUser->id;
        
        $profileHasMusics->save();
        $currentProfile->save();
        $newVenda->save();

        return $this->redirect('/musics/index');
    }

    /**
     * Creates a new Musics model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionAugment(){
        return $this->render('augment');
    }

    public function actionCreate()
    {

        $currentProfile = $this->getCurrentProfile();
        $currentUser = $this->getCurrentUser();

        if($currentProfile->isprodutor == 'N' || is_null($currentProfile->isprodutor)){
            return $this->redirect(['index']);
        }


        $model = new Musics();
        $modelGenres = Genres::find()->all();
        $modelYourAlbums = $this->getProducerAlbums();

        if ($model->load(Yii::$app->request->post())) {
            
            $path = "uploads/";
            if(!file_exists($path))
                mkdir($path, 0777, true);

            $getMusicFile = \yii\web\UploadedFile::getInstance($model, 'musicFile');//Get the uploaded file
            $getImageFile = \yii\web\UploadedFile::getInstance($model, 'imageFile');

            if (!empty($getMusicFile))
                $model->musicFile = $getMusicFile;
            else
                return $this->render('augment');
            if(!empty($getImageFile))
                $model->imageFile = $getImageFile;
            else
                return $this->render('augment');

            if (!file_exists($path.$currentUser->id)) 
                    mkdir($path.$currentUser->id, 0777, true);
                
            $pathToSong = $path.$currentUser->id."/";
            $model->musicpath = $pathToSong;
            $model->musiccover = $pathToSong;
            $model->launchdate = date("Y/m/d");
            if($model->save())
            {
                if (!empty($getMusicFile))
                    $getMusicFile->saveAs( $pathToSong . "music_" .$model->id . "_" . $model->title ."." . $getMusicFile->extension);
                if (!empty($getImageFile))
                    $getImageFile->saveAs( $pathToSong . "image_" .$model->id . "." . $getImageFile->extension);

                $currentUser = $this->getCurrentUser();
                $profileHasMusics = new ProfileHasMusics();

                $profileHasMusics->profile_id = $currentUser->id;

                $profileHasMusics->musics_id = $model->id;

                $profileHasMusics->save(); 

            }

            return $this->redirect(['user/index']);
        }

        return $this->render('create', [
            'model' => $model,
            'modelGenres' => $modelGenres,
            'modelYourAlbums' => $modelYourAlbums,
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


    private function getProducerAlbumsIds(){
        $profile = $this->getCurrentProfile();
        $ProfileHasAlbums = ProfileHasAlbums::find()->where(['profile_id' => Yii::$app->user->id])->all();
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


    //GET TODAS AS MUSICAS COM PRODUTOR
        public function getMusicasComProdutorReturnsArray(){
            $profileHasMusics = ProfileHasMusics::find()->all();
            $arrayComTodasAsMusicas = [];
            $criadorDestaMusica = null;
            $musicaDesteProfile = null;
            array_filter($arrayComTodasAsMusicas);
            foreach ($profileHasMusics as $phm) {
                $criadorDestaMusica = User::find()->where(['id' => $phm->profile_id])->one();
                $musicaDesteProfile = Musics::find()->where(['id' => $phm->musics_id])->one();

                //BaseVarDumper::dump($criadorDestaMusica);
                $musicaDesteProfile->producerOfThisSong = $criadorDestaMusica->username;
                //BaseVarDumper::dump($musicaDesteProfile);
                array_push($arrayComTodasAsMusicas, $musicaDesteProfile);
                //BaseVarDumper::dump($arrayComTodasAsMusicas);
                //echo "<br><br><br>";
            }
            return $arrayComTodasAsMusicas;
        }

        public function converterMusicasComProducerArrayParaObject(){
            $todasAsMusicas = Musics::find()->all();

            $todasAsMusicasArray = $this->getMusicasComProdutorReturnsArray();



            for ($i=0; $i < count($todasAsMusicasArray); $i++) { 
                if($todasAsMusicas[$i]->id == $todasAsMusicasArray[$i]->id){
                    $todasAsMusicas[$i]->producerOfThisSong = $todasAsMusicasArray[$i]->producerOfThisSong;
                }
            }

            return $todasAsMusicas;
        }


    //GET MUSICAS DO USER LOGADO
        public function getVendasUserLogadoIds(){
            $profile = $this->getCurrentProfile();
            $vendaDoUserLogado = Venda::find()->where(['profile_id' => $profile->id])->all();
            $linhasvendaArray[] = null;
            foreach ($vendaDoUserLogado as $venda) {
                array_push($linhasvendaArray, $venda->id);
            }
            return $linhasvendaArray;
        }
        public function getLinhavendaUserLogado(){
            $arrayVendasIds[] = $this->getVendasUserLogadoIds();
            $LinhavendaUserLogado = null;
            foreach ($arrayVendasIds as $venda) {
                $LinhavendaUserLogado = Linhavenda::find()->where(['venda_id' => $venda])->all();
            }
            return $LinhavendaUserLogado;
        }
        public function getMusicasPelasLinhaDeVendaDoUserLogado(){
            $LinhavendaDoUser = $this->getLinhavendaUserLogado();
            $musicasCompradasPeloUser = null;
            foreach ($LinhavendaDoUser as $linhavenda) {
                $musicasCompradasPeloUser = Musics::find()->where(['id' => $linhavenda->musics_id])->all();
                //$musicasCompradasPeloUser->producerOfThisSong = 
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
            for ($i=0; $i < count($arrayComTodasAsMusicas); $i++) { 
                
                foreach ($musicasCompradasPeloUser as $musicaComprada) {
                    if($musicaComprada->id == $arrayComTodasAsMusicas[$i]->id){
                        $musicaComprada->producerOfThisSong = $arrayComTodasAsMusicas[$i]->producerOfThisSong;
                    }
                }
            }        
            return $musicasCompradasPeloUser;
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
        $modelGenres = Genres::find()->all();
        $modelYourAlbums = $this->getProducerAlbums();
        
        if ($model->load(Yii::$app->request->post())) {

            $currentProfile = $this->getCurrentProfile();
            $currentUser = $this->getCurrentUser();

            $path = "uploads/";

            $getImageFile = \yii\web\UploadedFile::getInstance($model, 'imageFile');
            


            if(is_null($getImageFile)){
                $model->save();
                return $this->redirect(['user/index']);
            }
            

            if(!empty($getImageFile))
                $model->imageFile = $getImageFile;
            else
                return $this->render('augment');

            $pathToSong = $path.$currentUser->id."/";
            $model->musiccover = $pathToSong;


            $model->save();

            if (!empty($getImageFile))
                $getImageFile->saveAs( $pathToSong . "image_" .$model->id . "." . $getImageFile->extension);
            
            return $this->redirect(['user/index']);
        }

        return $this->render('update', [
            'model' => $model,
            'modelGenres' => $modelGenres,
            'modelYourAlbums' => $modelYourAlbums,
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
