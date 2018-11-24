<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/24/18
 * Time: 11:01 AM
 */

namespace App\Transformers;

use Illuminate\Support\Facades\Storage;

class AttachmentTransformer extends Transformer
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
            'path' => Storage::disk('productAttachments')->url($model->getPath()),
        );
    }
}