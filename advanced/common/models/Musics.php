<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%musics}}".
 *
 * @property int $id
 * @property string $title
 * @property string $launchdate
 * @property string $rating
 * @property string $lyrics
 * @property double $pvp
 * @property string $musiccover
 * @property string $musicpath
 * @property int $genres_id
 * @property int $albums_id
 * @property int $iva_id
 * @property int $profile_id
 *
 * @property Linhavenda[] $linhavendas
 * @property Albums $albums
 * @property Genres $genres
 * @property Iva $iva
 * @property Profile $profile
 * @property PlaylistsHasMusics[] $playlistsHasMusics
 * @property Playlists[] $playlists
 */
class Musics extends \yii\db\ActiveRecord
{

    public $musicFile;     
    public $imageFile;

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
            [['musicFile'], 'file', 'extensions' => 'mp3'],
            [['imageFile'], 'file', 'extensions' => 'png'],
            [['title', 'launchdate', 'profile_id', 'musicFile', 'imageFile'], 'required'],
            [['launchdate'], 'safe'],
            [['rating', 'pvp'], 'number'],
            [['lyrics'], 'string'],
            [['genres_id', 'albums_id', 'iva_id', 'profile_id'], 'integer'],
            [['title'], 'string', 'max' => 64],
            [['musiccover', 'musicpath'], 'string', 'max' => 100],
            [['albums_id'], 'exist', 'skipOnError' => true, 'targetClass' => Albums::className(), 'targetAttribute' => ['albums_id' => 'id']],
            [['genres_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genres::className(), 'targetAttribute' => ['genres_id' => 'id']],
            [['iva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Iva::className(), 'targetAttribute' => ['iva_id' => 'id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
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
            'musiccover' => 'Musiccover',
            'musicpath' => 'Musicpath',
            'genres_id' => 'Genres ID',
            'albums_id' => 'Albums ID',
            'iva_id' => 'Iva ID',
            'profile_id' => 'Profile ID',
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
        return $this->hasOne(Albums::className(), ['id' => 'albums_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenres()
    {
        return $this->hasOne(Genres::className(), ['id' => 'genres_id']);
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
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylistsHasMusics()
    {
        return $this->hasMany(PlaylistsHasMusics::className(), ['musics_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylists()
    {
        return $this->hasMany(Playlists::className(), ['id' => 'playlists_id'])->viaTable('{{%playlists_has_musics}}', ['musics_id' => 'id']);
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

