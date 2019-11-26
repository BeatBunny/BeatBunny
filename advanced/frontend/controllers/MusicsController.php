<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Profile;
use common\models\ProfileHasMusics;
use common\models\ProfileHasAlbums;
use common\models\Genres;
use common\models\Albums;
use common\models\Musics;
use common\models\Iva;
use common\models\SearchMusics;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\BaseVarDumper;
use yii\web\UploadedFile;
use common\models\Venda;
use common\models\Linhavenda;


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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $searchedMusics = Musics::find()->where("title LIKE '%".$searchModel->title."%'")->all();

        $serchedMusicsWithProducer = $this->putProducersInMusics($searchedMusics);

        $currentUser = $this->getCurrentUser();
        if(!is_null($currentUser)){

            if(!empty($this->getMusicasCompradasdoUserLogado())){
                $musicasCompradasPeloUser = $this->putProducersInMusics($this->getMusicasCompradasdoUserLogado());

                return $this->render('index', [
                    'musicasCompradasPeloUser' => $musicasCompradasPeloUser,
                    'serchedMusicsWithProducer' => $serchedMusicsWithProducer,
                    'searchModel' => $searchModel,
                    'allTheMusicsWithProducer' => $allTheMusicsWithProducer,
                    'currentUser' => $currentUser,
                ]);
            }
            else{
                
                return $this->render('index', [
                    'serchedMusicsWithProducer' => $serchedMusicsWithProducer,
                    'searchModel' => $searchModel,
                    'allTheMusicsWithProducer' => $allTheMusicsWithProducer,
                    'currentUser' => $currentUser,
                ]);

            }

        }

        return $this->render('index', [
            'serchedMusicsWithProducer' => $serchedMusicsWithProducer,
            'searchModel' => $searchModel,
            'allTheMusicsWithProducer' => $allTheMusicsWithProducer,
        ]);
    }


    public function getMusicasCompradasdoUserLogado(){
        $profileProvider = $this->getCurrentProfile();
        $userProvider = $this->getCurrentUser();
        $comprasDoUser = [];
        foreach ($profileProvider->vendas as $venda) {
            array_push($comprasDoUser, $venda->linhavendas[0]->musics);
        }
        return $comprasDoUser;
    }


    public function putProducersInMusics($searchedMusics){

        $allTheMusicsWithProducer = $this->converterMusicasComProducerArrayParaObject();


        for ($i=0; $i < count($allTheMusicsWithProducer); $i++) { 
            if($allTheMusicsWithProducer[$i]->id === $searchedMusics[$i]->id){
                $searchedMusics[$i]->producerOfThisSong = $allTheMusicsWithProducer[$i]->producerOfThisSong;
            }
        }

        return $searchedMusics;

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
            return $this->goBack();
        }

        $currentUser = $this->getCurrentUser();
        $currentProfile = $this->getCurrentProfile();
        $musicasCompradasPeloUser = null; //$this->getMusicasPelasLinhaDeVendaDoUserLogadoTesteMeterNomeProdutorNaMusica();
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
                'model' => $model,
                'producerOfThisSong' => $producerOfThisSong,
                'currentUser' => $currentUser,
                'currentProfile' => $currentProfile,
                'musicasCompradasPeloUser' => $musicasCompradasPeloUser,
            ]);
        }
    }

    public function actionFinishpayment($id){
        //IMPLEMENTAR VERIFICAÇÃO PARA VER SE O USER JÁ TEM A MÚSICA EM QUESTÃO
        $model = $this->findModel($id);
        $currentProfile = $this->getCurrentProfile();
        $currentUser = $this->getCurrentUser();
        
        $currentProfile->saldo = $currentProfile->saldo-$model->pvp;

        $newVenda = new Venda();
        $newVenda->data = date("Y/m/d");
        $newVenda->valorTotal = $model->pvp;
        $newVenda->profile_id = $currentProfile->id;
        
        $newVenda->save();

        $newLinhaVenda = new Linhavenda();
        $newLinhaVenda->precoVenda = $model->pvp;
        $newLinhaVenda->venda_id = $newVenda->id;
        $newLinhaVenda->musics_id = $model->id;
        
        $newLinhaVenda->save();
        $currentProfile->save();

        return $this->goBack();
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

                $profileHasMusics->profile_id = $currentProfile->id;

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

                $criadorDestaMusicaProfile = Profile::find()->where(['id' => $phm->profile_id])->one();
                $criadorDestaMusicaUser = User::find()->where(['id' => $criadorDestaMusicaProfile->id_user])->one();
                $musicaDesteProfile = Musics::find()->where(['id' => $phm->musics_id])->one();

                //BaseVarDumper::dump($criadorDestaMusica);
                $musicaDesteProfile->producerOfThisSong = $criadorDestaMusicaUser->username;
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
        //$this->findModel($id)->delete();

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
