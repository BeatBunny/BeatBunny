<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "profile_has_playlists".
 *
 * @property int $profile_id
 * @property int $playlists_id
 *
 * @property Playlists $playlists
 * @property Profile $profile
 */
class ProfileHasPlaylists extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_has_playlists';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'playlists_id'], 'required'],
            [['profile_id', 'playlists_id'], 'integer'],
            [['profile_id', 'playlists_id'], 'unique', 'targetAttribute' => ['profile_id', 'playlists_id']],
            [['playlists_id'], 'exist', 'skipOnError' => true, 'targetClass' => Playlists::className(), 'targetAttribute' => ['playlists_id' => 'id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profile_id' => 'Profile ID',
            'playlists_id' => 'Playlists ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylists()
    {
        return $this->hasOne(Playlists::className(), ['id' => 'playlists_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProfileHasPlaylistsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileHasPlaylistsQuery(get_called_class());
    }
}
