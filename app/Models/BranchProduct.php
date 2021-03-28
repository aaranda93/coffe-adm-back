<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class BranchProduct extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'branch_id',
        'product_id',
        'price',
        'discount',
        'stock',
        'status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $table = 'branch_product';    
    
    protected $casts = [
        'id' => 'string'
    ];

    protected $keyType = 'string';
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }
}
