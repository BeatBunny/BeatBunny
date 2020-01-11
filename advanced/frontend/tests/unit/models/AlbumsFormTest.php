<?php
/**
 * Created by PhpStorm.
 * User: MadriX
 * Date: 28/12/2019
 * Time: 01:18
 */

namespace frontend\tests\unit\models;
use common\models\Albums;

class AlbumsFormTest extends \Codeception\Test\Unit
{
    protected $tester;

    public function testAlbumTitleValidation()
    {
        $model = new Albums();
        $model->title = 'ffffffffffffffffffffffffffffffffffff323232#"#ddsdsfdaaasdsadsa';
        $this->assertFalse($model->validate(['title']));
        $model->title = "ColdPlay";
        $this->assertTrue($model->validate(['title']));
        return $model->title;
    }

    public function testAlbumReviewValidation()
    {
        $model = new Albums();
        $model->review = 's#"#d';
        $this->assertFalse($model->validate(['review']));
        $model->review = 5;
        $this->assertTrue($model->validate(['review']));
        return $model->review;
    }

    public function testAlbumGenresIdValidation()
    {
        $model = new Albums();
        $model->genres_id = ' ';
        $this->assertFalse($model->validate(['genres_id']));
        $model->genres_id = 's#"#d';
        $this->assertFalse($model->validate(['genres_id']));
        $model->genres_id = 1;
        $this->assertTrue($model->validate(['genres_id']));
        return $model->genres_id;
    }


    public function testAlbumInputTrueValidation()
    {
        $this->tester->haveRecord ('common\models\Albums',[
            'title' => $this->testAlbumTitleValidation(),
            'launchdate' => '2019-12-24',
            'review' => $this->testAlbumReviewValidation(),
            'albumcover' => ' ',
            'genres_id' => $this->testAlbumGenresIdValidation(),
        ]);
        $this->tester->seeRecord('common\models\Albums', array('title' => 'ColdPlay'));
    }

}