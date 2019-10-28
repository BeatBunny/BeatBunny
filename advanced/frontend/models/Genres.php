<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%genres}}".
 *
 * @property int $id
 * @property string $nome
 *
 * @property Album[] $albums
 * @property Music[] $musics
 */
class Genres extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%genres}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'], 'string', 'max' => 45],
            [['nome'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbums()
    {
        return $this->hasMany(Album::className(), ['genres_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMusics()
    {
        return $this->hasMany(Music::className(), ['genres_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return GenresQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GenresQuery(get_called_class());
    }
}
