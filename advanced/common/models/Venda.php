<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

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

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $id = $this->id;
        $data = $this->data;
        $valortotal = $this->valorTotal;
        $musics_id = $this->musics_id;
        $profile_id = $this->profile_id;

        $myObj = new Venda();
        $myObj->id = $id;
        $myObj->data = $data;
        $myObj->valorTotal = $valortotal;
        $myObj->musics_id = $musics_id;
        $myObj->profile_id = $profile_id;

        $myJSON = Json::encode($myObj);
        if ($insert)
            $this->FazPublish("INSERT_Um_Utilizador_Comprou_Uma_Musica", $myJSON);
    }


    public function FazPublish($canal, $msg)
    {
        $server = '127.0.0.1';
        $port = 1883;
        $username = "";
        $password = "";
        $client_id = uniqid();
        $mqtt= new phpMQTT($server, $port, $client_id);
        try {
            if ($mqtt->connect(true)) {
                $mqtt->publish($canal, $msg, 1);
                $mqtt->disconnect();
                $mqtt->close();
            } else {
                file_put_contents("debug.output", "Time out!");
            }
        }catch (\Exception $X)
        {}
    }
}
