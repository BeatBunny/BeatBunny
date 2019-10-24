<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProfileHasMusics]].
 *
 * @see ProfileHasMusics
 */
class ProfileHasMusicsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProfileHasMusics[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProfileHasMusics|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
