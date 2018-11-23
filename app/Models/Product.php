<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'upc',
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
    public function getUPC(): ?int
    {
        return (int)$this->upc;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @return HasMany
     */
    public function attachments(): HasMany
    {
        return $this->hasMany('App\Models\Attachment', 'product_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function productVersions(): HasMany
    {
        return $this->hasMany('App\Models\ProductVersion', 'product_id', 'id');
    }

    /**
     * @return BelongsToMany // todo check and update, as it is not many to many
     */
    public function category(): belongsToMany
    {
        return $this->belongsToMany('App\Models\Category', 'category_product', 'product_id', 'category_id')
            ->whereNull('parent_id');
    }

    /**
     * @return BelongsToMany
     */
    public function subCategory(): belongsToMany
    {
        return $this->belongsToMany('App\Models\Category', 'category_product', 'product_id', 'category_id')
            ->whereNotNull('parent_id');
    }
}
