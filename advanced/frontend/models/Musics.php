<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%musics}}".
 *
 * @property int $id
 * @property string $title
 * @property string $launchdate
 * @property string $rating
 * @property string $lyrics
 * @property double $pvp
 * @property int $genres_id
 * @property int $albums_id
 * @property int $iva_id
 *
 * @property Linhavenda[] $linhavendas
 * @property Album $albums
 * @property Genre $genres
 * @property Iva $iva
 * @property Playlist[] $playlists
 * @property PlaylistsHasMusic[] $playlistsHasMusics
 * @property Playlist[] $playlists0
 * @property ProfileHasMusic[] $profileHasMusics
 * @property Profile[] $profiles
 */
class Musics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%musics}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'launchdate', 'genres_id', 'albums_id', 'iva_id'], 'required'],
            [['launchdate'], 'safe'],
            [['rating', 'pvp'], 'number'],
            [['lyrics'], 'string'],
            [['genres_id', 'albums_id', 'iva_id'], 'integer'],
            [['title'], 'string', 'max' => 64],
            [['albums_id'], 'exist', 'skipOnError' => true, 'targetClass' => Album::className(), 'targetAttribute' => ['albums_id' => 'id']],
            [['genres_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::className(), 'targetAttribute' => ['genres_id' => 'id']],
            [['iva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Iva::className(), 'targetAttribute' => ['iva_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'launchdate' => 'Launchdate',
            'rating' => 'Rating',
            'lyrics' => 'Lyrics',
            'pvp' => 'Pvp',
            'genres_id' => 'Genres ID',
            'albums_id' => 'Albums ID',
            'iva_id' => 'Iva ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinhavendas()
    {
        return $this->hasMany(Linhavenda::className(), ['musics_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbums()
    {
        return $this->hasOne(Album::className(), ['id' => 'albums_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenres()
    {
        return $this->hasOne(Genre::className(), ['id' => 'genres_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIva()
    {
        return $this->hasOne(Iva::className(), ['id' => 'iva_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylists()
    {
        return $this->hasMany(Playlist::className(), ['musics_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylistsHasMusics()
    {
        return $this->hasMany(PlaylistsHasMusic::className(), ['musics_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylists0()
    {
        return $this->hasMany(Playlist::className(), ['id' => 'playlists_id'])->viaTable('{{%playlists_has_musics}}', ['musics_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileHasMusics()
    {
        return $this->hasMany(ProfileHasMusic::className(), ['musics_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['id' => 'profile_id'])->viaTable('{{%profile_has_musics}}', ['musics_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return MusicsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MusicsQuery(get_called_class());
    }
}
