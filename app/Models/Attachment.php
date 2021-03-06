<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
    protected $table = 'attachments';

    protected $fillable = [
        'product_id',
        'path',
        'thumbnail',
    ];

    protected $hidden = [
        'updated_at',
    ];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return (int)$this->id;
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return (int)$this->product_id;
    }

    /**
     * @return null|string
     */
    public function getPath(): ?string
    {
        return (string)$this->path;
    }

    /**
     * @return string|null
     */
    public function getThumbnail(): ?string
    {
        return (string)$this->thumbnail;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $attributes = $this->attributesToArray();
        $attributes['path'] = \Storage::disk('productAttachments')->url($attributes['path']);

        return array_merge($attributes, $this->relationsToArray());
    }
}
