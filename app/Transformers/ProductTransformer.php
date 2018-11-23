<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/23/18
 * Time: 10:43 PM
 */

namespace App\Transformers;


class ProductTransformer extends Transformer
{
    /**
     * @param $model
     * @return array
     */
    public function transform($model)
    {
        return array(
            'id' => $model->getId(),
            'upc' => $model->getUPC(),
        );
    }
}