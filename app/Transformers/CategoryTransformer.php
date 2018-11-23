<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/23/18
 * Time: 9:46 PM
 */

namespace App\Transformers;


class CategoryTransformer extends Transformer
{
    /**
     * @param $model
     * @return array
     */
    public function transform($model)
    {
        return array(
            'id' => $model->getId(),
            'name' => $model->getName(),
            'parent_id' => $model->getParentId(),
        );
    }
}