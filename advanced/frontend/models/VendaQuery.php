<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Venda]].
 *
 * @see Venda
 */
class VendaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Venda[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Venda|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
