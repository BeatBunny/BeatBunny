<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Linhavenda]].
 *
 * @see Linhavenda
 */
class LinhavendaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Linhavenda[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Linhavenda|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
