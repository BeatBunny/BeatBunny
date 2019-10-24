<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProfileHasPlaylists]].
 *
 * @see ProfileHasPlaylists
 */
class ProfileHasPlaylistsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProfileHasPlaylists[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProfileHasPlaylists|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
