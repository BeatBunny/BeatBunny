<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%venda}}".
 *
 * @property int $id
 * @property string $data
 * @property double $valorTotal
 * @property int $musics_id
 * @property int $profile_id
 *
 * @property Musics $musics
 * @property Profile $profile
 */
class Venda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%venda}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data'], 'safe'],
            [['valorTotal'], 'number'],
            [['musics_id', 'profile_id'], 'required'],
            [['musics_id', 'profile_id'], 'integer'],
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
            'id' => 'ID',
            'data' => 'Data',
            'valorTotal' => 'Valor Total',
            'musics_id' => 'Musics ID',
            'profile_id' => 'Profile ID',
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
     * @return VendaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VendaQuery(get_called_class());
    }
}
