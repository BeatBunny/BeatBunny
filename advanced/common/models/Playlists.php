<?php

namespace common\models;
use yii\helpers\BaseVarDumper;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%playlists}}".
 *
 * @property int $id
 * @property string $nome
 * @property string $ispublica
 * @property string $creationdate
 *
 * @property PlaylistsHasMusics[] $playlistsHasMusics
 * @property Musics[] $musics
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
            [['nome'], 'required'],
            [['ispublica'], 'string'],
            [['creationdate'], 'safe'],
            [['nome'], 'string', 'max' => 45],
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
            'creationdate' => 'Creationdate',
        ];
    }

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
        $creationdate = $this->creationdate;
        $myObj=new Playlists();
        $myObj->id=$id;
        $myObj->creationdate =$creationdate;
        $myObj->ispublica =$ispublica;
        $myObj->nome=$nome;
        $myJSON = Json::encode($myObj);
        if($insert) {
            $this->FazPublish("INSERT", $myJSON);
        } else
            $this->FazPublish("UPDATE",$myJSON);
    }

    public function FazPublish($canal, $msg)
    {
        $server = '127.0.0.1';
        $port = 1883;
        $username = "";
        $password = "";
        $client_id = uniqid();
        $mqtt= new phpMQTT($server, $port, $client_id);
        if ($mqtt->connect(true)) {
            $mqtt->publish($canal, $msg, 0);
            $mqtt->disconnect();
            $mqtt->close();
            
        } else {
            file_put_contents("debug.output", "Time out!");
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $prod_id= $this->id;
        $myObj=new Playlists();
        $myObj->id=$prod_id;
        $myJSON = Json::encode($myObj);
        $this->FazPublish("DELETE",$myJSON);
    }
}
