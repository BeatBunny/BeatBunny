<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%iva}}".
 *
 * @property int $id
 * @property int $tax
 *
 * @property Music[] $musics
 */
class Iva extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%iva}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'tax'], 'integer'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tax' => 'Tax',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMusics()
    {
        return $this->hasMany(Music::className(), ['iva_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return IvaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IvaQuery(get_called_class());
    }
}
