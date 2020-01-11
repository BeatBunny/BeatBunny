<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%playlists}}".
 *
 * @property int $id
 * @property string $nome
 * @property string $ispublica
 * @property int $musics_id
 *
 * @property Musics $musics
 * @property PlaylistsHasMusics[] $playlistsHasMusics
 * @property Musics[] $musics0
 * @property ProfileHasPlaylists[] $profileHasPlaylists
 * @property Profile[] $profiles
 */
class Playlists extends \yii\db\ActiveRecord
{

    public $generosDaPlaylist = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%playlists}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'musics_id'], 'required'],
            [['ispublica'], 'string'],
            [['musics_id'], 'integer'],
            [['nome'], 'string', 'max' => 45],
            [['musics_id'], 'exist', 'skipOnError' => true, 'targetClass' => Musics::className(), 'targetAttribute' => ['musics_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'ispublica' => 'Ispublica',
            'musics_id' => 'Musics ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getMusics()
    {
        return $this->hasOne(Musics::className(), ['id' => 'musics_id']);
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylistsHasMusics()
    {
        return $this->hasMany(PlaylistsHasMusics::className(), ['playlists_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMusics()
    {
        return $this->hasMany(Musics::className(), ['id' => 'musics_id'])->viaTable('{{%playlists_has_musics}}', ['playlists_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileHasPlaylists()
    {
        return $this->hasMany(ProfileHasPlaylists::className(), ['playlists_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['id' => 'profile_id'])->viaTable('{{%profile_has_playlists}}', ['playlists_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PlaylistsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PlaylistsQuery(get_called_class());
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $id = $this->id;
        $nome = $this->nome;
        $ispublica = $this->ispublica;

        $myObj = new Playlists();
        $myObj->id = $id;
        $myObj->nome = $nome;
        $myObj->ispublica = $ispublica;

        $myJSON = Json::encode($myObj);
        if ($insert) {
            $this->FazPublish("INSERT_Um_Utilizador_Comprou_Uma_Playlist", $myJSON);
        }else{
            $this->FazPublish("UPDATE_Uma_Das_Suas_Playlists_Foi_Atualizada", $myJSON);
        }
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

    public function afterDelete()
    {
        parent::afterDelete();
        $prod_id= $this->id;
        $myObj=new Playlists();
        $myObj->id=$prod_id;
        $myJSON = Json::encode($myObj);
        $this->FazPublish("DELETE_Uma_Das_Suas_Playlists_Foi_Eliminada",$myJSON);
    }

}
