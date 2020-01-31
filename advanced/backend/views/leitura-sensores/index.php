<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchLeituraSensores */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leitura Sensores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leitura-sensores-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Leitura Sensores', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="row">
            
        <div class="col-lg-12" style="border: 1px solid black">
            <!-- temperatura', 'humidade', 'luminosidade', 'descricao -->
            <div class="row">
                <div class="col-lg-3" style="border: 1px solid black">
                    <p>temperatura</p>
                </div>
                <div class="col-lg-3" style="border: 1px solid black">
                    <p>humidade</p>
                </div>
                <div class="col-lg-3" style="border: 1px solid black">
                    <p>luminosidade</p>
                </div>
                <div class="col-lg-3" style="border: 1px solid black">
                    <p>descricao</p>
                </div>
            </div>
            <?php 
                foreach ( $allLeituras as $leitura ) {
                    ?>
                    <div class="row" style="border: 1px solid black">
                        <div class="col-lg-3" style="border: 1px solid black">
                            
                            
                            <?php
                                if($leitura->temperatura <= 9){
                                    echo '<span style="color: blue">';
                                }
                                elseif ($leitura->temperatura > 9 && $leitura->temperatura <= 19) {
                                    echo '<span style="color: orange">';
                                }
                                elseif ($leitura->temperatura > 19) {
                                    echo '<span style="color: red">';
                                }
                                echo $leitura->temperatura;
                                echo "</span>";
                            ?>


                        </div>
                        <div class="col-lg-3" style="border: 1px solid black">
                            <?php
                                echo $leitura->humidade;
                            ?>
                        </div>
                        <div class="col-lg-3" style="border: 1px solid black">
                            <?php
                                echo $leitura->luminosidade;
                            ?>
                        </div>
                        <div class="col-lg-3" style="border: 1px solid black">
                            <?php
                                echo $leitura->descricao;
                            ?>
                        </div>
                    </div>

                    <?php
                }
            ?>
        </div>

    </div>
</div>
