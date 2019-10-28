<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%linhavenda}}".
 *
 * @property int $id
 * @property double $precoVenda
 * @property int $venda_id
 * @property int $musics_id
 *
 * @property Music $musics
 * @property Venda $venda
 */
class Linhavenda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%linhavenda}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['precoVenda'], 'number'],
            [['venda_id', 'musics_id'], 'required'],
            [['venda_id', 'musics_id'], 'integer'],
            [['musics_id'], 'exist', 'skipOnError' => true, 'targetClass' => Musics::className(), 'targetAttribute' => ['musics_id' => 'id']],
            [['venda_id'], 'exist', 'skipOnError' => true, 'targetClass' => Venda::className(), 'targetAttribute' => ['venda_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'precoVenda' => 'Preco Venda',
            'venda_id' => 'Venda ID',
            'musics_id' => 'Musics ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMusics()
    {
        return $this->hasOne(Music::className(), ['id' => 'musics_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenda()
    {
        return $this->hasOne(Venda::className(), ['id' => 'venda_id']);
    }

    /**
     * {@inheritdoc}
     * @return LinhavendaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LinhavendaQuery(get_called_class());
    }
}
