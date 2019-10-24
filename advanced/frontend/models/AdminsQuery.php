<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Admins]].
 *
 * @see Admins
 */
class AdminsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Admins[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Admins|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
