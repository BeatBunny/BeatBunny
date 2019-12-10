<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%playlists}}".
 *
 * @property int $id
 * @property string $nome
 * @property string $ispublica
 * @property string $creationdate
 *
 * @property PlaylistsHasMusics[] $playlistsHasMusics
 * @property Musics[] $musics
 * @property ProfileHasPlaylists[] $profileHasPlaylists
 * @property Profile[] $profiles
 */
class Playlists extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%playlists}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['ispublica'], 'string'],
            [['creationdate'], 'safe'],
            [['nome'], 'string', 'max' => 45],
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
            'ispublica' => 'Ispublica',
            'creationdate' => 'Creationdate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylistsHasMusics()
    {
        return $this->hasMany(PlaylistsHasMusics::className(), ['playlists_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMusics()
    {
        return $this->hasMany(Musics::className(), ['id' => 'musics_id'])->viaTable('{{%playlists_has_musics}}', ['playlists_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileHasPlaylists()
    {
        return $this->hasMany(ProfileHasPlaylists::className(), ['playlists_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['id' => 'profile_id'])->viaTable('{{%profile_has_playlists}}', ['playlists_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PlaylistsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PlaylistsQuery(get_called_class());
    }
}
