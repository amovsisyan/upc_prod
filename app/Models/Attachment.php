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
    ];

    /**
     * @return int|null
     */
    public function getDescription(): ?int
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
}
