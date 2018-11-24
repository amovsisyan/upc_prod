<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'upc',
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
     * @return HasMany
     */
    public function activeProductVersions(): hasOne
    {
        return $this->hasOne('App\Models\ProductVersion', 'product_id', 'id')
            ->where('active', 1)->orderBy('id', 'desc');
    }

    /**
     * @return BelongsToMany // todo check and update, as it is not many to many
     */
    public function categories(): belongsToMany
    {
        return $this->belongsToMany('App\Models\Category', 'category_product', 'product_id', 'category_id')
            ->whereNull('parent_id');
    }

    /**
     * @return BelongsToMany
     */
    public function subCategories(): belongsToMany
    {
        return $this->belongsToMany('App\Models\Category', 'category_product', 'product_id', 'category_id')
            ->whereNotNull('parent_id');
    }
}
