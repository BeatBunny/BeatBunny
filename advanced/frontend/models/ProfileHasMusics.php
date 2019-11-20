<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "profile_has_musics".
 *
 * @property int $profile_id
 * @property int $musics_id
 *
 * @property Musics $musics
 * @property Profile $profile
 */
class ProfileHasMusics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_has_musics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'musics_id'], 'required'],
            [['profile_id', 'musics_id'], 'integer'],

            [['profile_id', 'musics_id'], 'unique', 'targetAttribute' => ['profile_id', 'musics_id']],
            [['musics_id'], 'exist', 'skipOnError' => true, 'targetClass' => Musics::className(), 'targetAttribute' => ['musics_id' => 'id']],
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
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProfileHasMusicsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileHasMusicsQuery(get_called_class());
    }
}
