<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%profile_has_albums}}".
 *
 * @property int $profile_id
 * @property int $albums_id
 *
 * @property Album $albums
 * @property Profile $profile
 */
class ProfileHasAlbums extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%profile_has_albums}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'albums_id'], 'required'],
            [['profile_id', 'albums_id'], 'integer'],
            [['profile_id', 'albums_id'], 'unique', 'targetAttribute' => ['profile_id', 'albums_id']],
            [['albums_id'], 'exist', 'skipOnError' => true, 'targetClass' => Albums::className(), 'targetAttribute' => ['albums_id' => 'id']],
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
            'albums_id' => 'Albums ID',
        ];
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
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProfileHasAlbumsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileHasAlbumsQuery(get_called_class());
    }
}
