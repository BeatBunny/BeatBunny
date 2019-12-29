<?php
/**
 * Created by PhpStorm.
 * User: MadriX
 * Date: 28/12/2019
 * Time: 01:18
 */

namespace frontend\tests\unit\models;
use common\fixtures\PlaylistsFixture as PlaylistsFixture;
use common\models\Playlists;

class PaylistsFormTest extends \Codeception\Test\Unit
{
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'playlists' => [
                'class' => PlaylistsFixture::className(),
            ],
        ]);
    }

    public function testPlaylistTitleValidation()
    {
        $model = new Playlists();
        $model->nome = 'ffffffffffffffffffffffffffffffffffff323232#"#ddsdsfdaaasdsadsa';
        $this->assertFalse($model->validate(['nome']));
        $model->nome = "ColdPlay";
        $this->assertTrue($model->validate(['nome']));
        return $model->nome;
    }

    public function testAlbumInputTrueValidation()
    {
        $model = new Playlists();
        $model->attributes = [
            'nome' => $this->testPlaylistTitleValidation(),
            'ispublica' => 'S',
            'creationdate' => '2019-12-24',
        ];
        $model->save();
        $this->tester->seeRecord('common\models\Playlists', array('nome' => 'ColdPlay'));
    }

}