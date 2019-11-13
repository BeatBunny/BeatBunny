<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%profile_has_musics}}".
 *
 * @property int $profile_id
 * @property int $musics_id
 */
class ProfileHasMusics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%profile_has_musics}}';
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
     * {@inheritdoc}
     * @return ProfileHasMusicsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileHasMusicsQuery(get_called_class());
    }
}
