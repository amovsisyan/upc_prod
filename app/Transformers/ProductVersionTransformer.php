<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/24/18
 * Time: 12:01 AM
 */

namespace App\Transformers;


class ProductVersionTransformer extends Transformer
{
    /**
     * @param $model
     * @return array
     */
    public function transform($model)
    {
        return array(
            'id' => $model->getId(),
            'product_id' => $model->getProductId(),
            'brand_id' => $model->getBrandId(),
            'title' => $model->getTitle(),
            'description' => $model->getDescription(),
            'width' => $model->getWidth(),
            'height' => $model->getHeight(),
            'length' => $model->getLength(),
            'weight' => $model->getWeight(),
            'active' => (bool)$model->getActive(),
        );
    }
}