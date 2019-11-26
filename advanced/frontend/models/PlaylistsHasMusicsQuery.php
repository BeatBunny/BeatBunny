<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PlaylistsHasMusics]].
 *
 * @see PlaylistsHasMusics
 */
class PlaylistsHasMusicsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PlaylistsHasMusics[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PlaylistsHasMusics|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
