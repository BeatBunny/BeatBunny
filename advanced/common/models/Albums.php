<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "albums".
 *
 * @property int $id
 * @property string $title
 * @property string $launchdate
 * @property string $review
 * @property resource $albumcover
 * @property int $genres_id
 *
 * @property Genres $genres
 * @property Musics[] $musics
 * @property ProfileHasAlbums[] $profileHasAlbums
 * @property Profile[] $profiles
 */
class Albums extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'albums';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'launchdate', 'genres_id'], 'required'],
            [['launchdate'], 'safe'],
            [['review'], 'number'],
            [['albumcover'], 'string'],
            [['genres_id'], 'integer'],
            [['title'], 'string', 'max' => 45],
            [['genres_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genres::className(), 'targetAttribute' => ['genres_id' => 'id']],
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
            'review' => 'Review',
            'albumcover' => 'Albumcover',
            'genres_id' => 'Genres ID',
        ];
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
    public function getMusics()
    {
        return $this->hasMany(Musics::className(), ['albums_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileHasAlbums()
    {
        return $this->hasMany(ProfileHasAlbums::className(), ['albums_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['id' => 'profile_id'])->viaTable('profile_has_albums', ['albums_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AlbumsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlbumsQuery(get_called_class());
    }
}
