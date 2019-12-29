<?php
/**
 * Created by PhpStorm.
 * User: MadriX
 * Date: 28/12/2019
 * Time: 00:33
 */
namespace frontend\tests\unit\models;
use common\fixtures\AlbumFixture as AlbumFixture;
use common\fixtures\IvaFixture as IvaFixture;
use common\fixtures\MusicsFixture as MusicsFixture;
use common\fixtures\UserFixture as UserFixture;
use common\models\Musics;

class MusicFormTest extends \Codeception\Test\Unit
{

    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'music' => [
                'class' => MusicsFixture::className(),
                'dataFile' => codecept_data_dir() . 'musics.php'
            ],'albums' => [
                'class' => AlbumFixture::className(),
                'dataFile' => codecept_data_dir() . 'albums.php'
            ], 'profiles' => [
                'class' => AlbumFixture::className(),
                'dataFile' => codecept_data_dir() . 'profile.php'
            ], 'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ], 'iva' => [
                'class' => IvaFixture::className(),
            ]
        ]);
    }

    public function testMusicTitleValidation()
    {
        $model = new Musics();
        $model->title = '####fddfaSFDFdsfef3rfrdhgbuynijkmo,plmjinhugbyvcftexszwadcfrthgbd';
        $this->assertFalse($model->validate(['title']));
        $model->title = "The Scientist";
        $this->assertTrue($model->validate(['title']));
        return $model->title;
    }

    public function testMusicPvpValidation()
    {
        $model = new Musics();
        $model->pvp = '####fddfaSFDFdsfef3rfrdhgbuynijkmo,plmjinhugbyvcftexszwadcfrthgbd';
        $this->assertFalse($model->validate(['pvp']));
        $model->pvp = "2.34";
        $this->assertTrue($model->validate(['pvp']));
        return $model->pvp;
    }


    public function testMusicRatingValidation()
    {
        $model = new Musics();
        $model->rating = 's#"#d';
        $this->assertFalse($model->validate(['rating']));
        $model->rating = '5';
        $this->assertTrue($model->validate(['rating']));
        return $model->rating;
    }

    public function testMusicGenresIdValidation()
    {
        $model = new Musics();
        $model->genres_id = ' ';
        $this->assertFalse($model->validate(['genres_id']));
        $model->genres_id = 's#"#d';
        $this->assertFalse($model->validate(['genres_id']));
        $model->genres_id = '1';
        $this->assertTrue($model->validate(['genres_id']));

        return $model->genres_id;
    }

    public function testMusicAlbumIdValidation()
    {
        $model = new Musics();

        $model->albums_id = 's#"#d';
        $this->assertFalse($model->validate(['albums_id']));
        $model->albums_id = '1';
        $this->assertTrue($model->validate(['albums_id']));
        return $model->albums_id;
    }

    public function testMusicInputTrueValidation()
    {
        $model = new Musics();
        $model->attributes = [
            'title' => $this->testMusicTitleValidation(),
            'launchdate' => '2019-12-24',
            'rating' => $this->testMusicRatingValidation(),
            'musiccover' => ' ',
            'lyrics' =>'',
            'pvp' =>$this->testMusicPvpValidation(),
            'musicpath' => '',
            'albums_id' =>$this->testMusicAlbumIdValidation(),
            'genres_id' => $this->testMusicGenresIdValidation(),
        ];
        $model->save();

        $this->tester->seeRecord('common\models\Musics', array( 'title' => $this->testMusicTitleValidation()));
    }


}