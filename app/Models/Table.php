<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Table extends Model
{

    /**
     * status.
     */
    const INACTIVE = 0;
    const AVAILABLE = 1;
    const OCCUPIED = 2;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'branch_id',
        'capacity',
        'status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $table = 'tables';   
    
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
