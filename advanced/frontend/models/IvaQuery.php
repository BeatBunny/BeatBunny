<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Iva]].
 *
 * @see Iva
 */
class IvaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Iva[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Iva|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
