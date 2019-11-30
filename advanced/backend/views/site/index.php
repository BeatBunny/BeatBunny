<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Backend</h1>
    </div>

    <div class="body-content">

        <div class="row textAlignCenter">
            <div class="col-lg-4 borderAllBlack">
                <h2>Users</h2>
                <p>
                    <?= Html::a('Check Table Users', ['/user/index'], ['class' => 'btn btn-default']) ?>
                </p>

            </div>
            <div class="col-lg-4 borderAllBlack">
                <h2>Albums</h2>
                <p>
                    <?= Html::a('Check Table Albums', ['/albums/index'], ['class' => 'btn btn-default']) ?>
                </p>

            </div>
            <div class="col-lg-4 borderAllBlack">
                <h2>Genres</h2>
                <p>
                    <?= Html::a('Check Table Genres', ['/genres/index'], ['class' => 'btn btn-default']) ?>
                </p>

            </div>
            <div class="col-lg-4 borderAllBlack">
                <h2>LinhaVenda</h2>
                <p>
                    <?= Html::a('Check Table LinhaVenda', ['/linhavenda/index'], ['class' => 'btn btn-default']) ?>
                </p>

            </div>
            <div class="col-lg-4 borderAllBlack">
                <h2>Musics</h2>
                <p>
                    <?= Html::a('Check Table Musics', ['/musics/index'], ['class' => 'btn btn-default']) ?>
                </p>

            </div>
            <div class="col-lg-4 borderAllBlack">
                <h2>Playlists</h2>
                <p>
                    <?= Html::a('Check Table Playlists', ['/playlists/index'], ['class' => 'btn btn-default']) ?>
                </p>

            </div>
            <div class="col-lg-4 borderAllBlack">
                <h2>Profile</h2>
                <p>
                    <?= Html::a('Check Table Profile', ['/profile/index'], ['class' => 'btn btn-default']) ?>
                </p>

            </div>
            <div class="col-lg-4 borderAllBlack">
                <h2>Venda</h2>
                <p>
                    <?= Html::a('Check Table Venda', ['/venda/index'], ['class' => 'btn btn-default']) ?>
                </p>

            </div>
            <div class="col-lg-4 borderAllBlack">
                <h2>Users</h2>
                <p>
                    <?= Html::a('Check Table Playlists Has Musics', ['/playlistshasmusics/index'], ['class' => 'btn btn-default']) ?>
                </p>

            </div>
            <div class="col-lg-4 borderAllBlack">
                <h2>Users</h2>
                <p>
                    <?= Html::a('Check Table Users', ['/user/index'], ['class' => 'btn btn-default']) ?>
                </p>

            </div>
            <div class="col-lg-4 borderAllBlack">
                <h2>Users</h2>
                <p>
                    <?= Html::a('Check Table Users', ['/user/index'], ['class' => 'btn btn-default']) ?>
                </p>

            </div>
            <div class="col-lg-4 borderAllBlack">
                <h2>Users</h2>
                <p>
                    <?= Html::a('Check Table Users', ['/user/index'], ['class' => 'btn btn-default']) ?>
                </p>

            </div>
        </div>

    </div>
</div>
