<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/23/18
 * Time: 8:00 AM
 */

namespace App\Transformers;

class BrandTransformer extends Transformer
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
            'created_at' => $model->created_at->toDateTimeString(),
        );
    }
}