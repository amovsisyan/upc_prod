<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVersion extends Model
{
    protected $table = 'product_versions';

    protected $fillable = [
        'product_id',
        'brand_id',
        'title',
        'description',
        'width',
        'height',
        'length',
        'weight',
        'active',
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
     * @return int|null
     */
    public function getBrandId(): ?int
    {
        return (int)$this->brand_id;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return (string)$this->title;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return (string)$this->description;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return (int)$this->width;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return (int)$this->height;
    }

    /**
     * @return int|null
     */
    public function getLength(): ?int
    {
        return (int)$this->length;
    }

    /**
     * @return int|null
     */
    public function getWeight(): ?int
    {
        return (int)$this->weight;
    }

    /**
     * @return int|null
     */
    public function getActive(): ?int
    {
        return (int)$this->active;
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
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id', 'id');
    }
}
