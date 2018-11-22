<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $table = 'brands';

    protected $fillable = [
        'name',
    ];

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return (string)$this->name;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @return HasMany
     */
    public function productVersions(): HasMany
    {
        return $this->hasMany('App\Models\ProductVersion', 'product_id', 'id');
    }
}
