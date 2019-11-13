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
 * @property resource $musiccover
 * @property string $musicpath
 * @property int $genres_id
 * @property int $albums_id
 * @property int $iva_id
 *
 * @property Album $albums
 * @property Genre $genres
 * @property Iva $iva
 * @property Playlist[] $playlists
 */
class Musics extends \yii\db\ActiveRecord
{

    public $musicFile;
    public $imageFile;
    public $producerOfThisSong;

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
            [['title', 'launchdate', 'musicFile', 'imageFile'], 'required'],
            [['launchdate'], 'safe'],
            [['rating', 'pvp'], 'number'],
            [['lyrics'], 'string'],
            [[ 'musiccover'], 'string', 'max' => 100],
            [['genres_id', 'albums_id', 'iva_id'], 'integer'],
            [['title'], 'string', 'max' => 64],
            [['musicpath'], 'string', 'max' => 100],
            [['albums_id'], 'exist', 'skipOnError' => true, 'targetClass' => Albums::className(), 'targetAttribute' => ['albums_id' => 'id']],
            [['genres_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genres::className(), 'targetAttribute' => ['genres_id' => 'id']],
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
            'musiccover' => 'Music Cover',
            'musicpath' => 'Musicpath',
            'genres_id' => 'Genres',
            'albums_id' => 'Album',
            'iva_id' => 'TAX (%)',
        ];
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
    public function getPlaylists()
    {
        return $this->hasMany(Playlists::className(), ['musics_id' => 'id']);
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
