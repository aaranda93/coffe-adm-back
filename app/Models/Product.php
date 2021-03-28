<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Product extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'name',
        'url_pic',
        'url_pic_min',
        'status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $table = 'products';
    
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
