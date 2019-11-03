<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%profile}}".
 *
 * @property int $id
 * @property string $saldo
 * @property string $nome
 * @property int $nif
 * @property string $isprodutor
 * @property int $id_user
 *
 * @property User $user
 * @property ProfileHasAlbum[] $profileHasAlbums
 * @property Album[] $albums
 * @property ProfileHasMusic[] $profileHasMusics
 * @property Music[] $musics
 * @property ProfileHasPlaylist[] $profileHasPlaylists
 * @property Playlist[] $playlists
 * @property Venda[] $vendas
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['saldo'], 'number'],
            [['nome', 'id_user'], 'required'],
            [['nif', 'id_user'], 'integer'],
            [['isprodutor'], 'string'],
            [['nome'], 'string', 'max' => 45],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'saldo' => 'Saldo',
            'nome' => 'Nome',
            'nif' => 'Nif',
            'isprodutor' => 'Isprodutor',
            'id_user' => 'Id User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileHasAlbums()
    {
        return $this->hasMany(ProfileHasAlbums::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbums()
    {
        return $this->hasMany(Albums::className(), ['id' => 'albums_id'])->viaTable('{{%profile_has_albums}}', ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileHasMusics()
    {
        return $this->hasMany(ProfileHasMusics::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMusics()
    {
        return $this->hasMany(Musics::className(), ['id' => 'musics_id'])->viaTable('{{%profile_has_musics}}', ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileHasPlaylists()
    {
        return $this->hasMany(ProfileHasPlaylists::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylists()
    {
        return $this->hasMany(Playlists::className(), ['id' => 'playlists_id'])->viaTable('{{%profile_has_playlists}}', ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendas()
    {
        return $this->hasMany(Venda::className(), ['profile_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileQuery(get_called_class());
    }
}
