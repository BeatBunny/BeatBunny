<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "playlists_has_musics".
 *
 * @property int $playlists_id
 * @property int $musics_id
 *
 * @property Musics $musics
 * @property Playlists $playlists
 */
class PlaylistsHasMusics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'playlists_has_musics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['playlists_id', 'musics_id'], 'required'],
            [['playlists_id', 'musics_id'], 'integer'],
            [['playlists_id', 'musics_id'], 'unique', 'targetAttribute' => ['playlists_id', 'musics_id']],
            [['musics_id'], 'exist', 'skipOnError' => true, 'targetClass' => Musics::className(), 'targetAttribute' => ['musics_id' => 'id']],
            [['playlists_id'], 'exist', 'skipOnError' => true, 'targetClass' => Playlists::className(), 'targetAttribute' => ['playlists_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'playlists_id' => 'Playlists ID',
            'musics_id' => 'Musics ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMusics()
    {
        return $this->hasOne(Musics::className(), ['id' => 'musics_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylists()
    {
        return $this->hasOne(Playlists::className(), ['id' => 'playlists_id']);
    }

    /**
     * {@inheritdoc}
     * @return PlaylistsHasMusicsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PlaylistsHasMusicsQuery(get_called_class());
    }
}
