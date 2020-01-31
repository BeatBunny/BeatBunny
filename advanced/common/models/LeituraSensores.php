<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "leitura_sensores".
 *
 * @property int $id
 * @property float $temperatura
 * @property float $humidade
 * @property float $luminosidade
 * @property string $descricao
 */
class LeituraSensores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leitura_sensores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['temperatura', 'humidade', 'luminosidade', 'descricao'], 'required'],
            [['temperatura', 'humidade', 'luminosidade'], 'number'],
            [['descricao'], 'string', 'max' => 254],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'temperatura' => 'Temperatura',
            'humidade' => 'Humidade',
            'luminosidade' => 'Luminosidade',
            'descricao' => 'Descricao',
        ];
    }
}
