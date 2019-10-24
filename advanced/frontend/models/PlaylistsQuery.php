<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Playlists]].
 *
 * @see Playlists
 */
class PlaylistsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Playlists[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Playlists|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
