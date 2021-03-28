<?php

namespace App\Models;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    const INACTIVE = 0;
    const ACTIVE = 1;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'name',
        'email',
        'url_pic',
        'url_pic_min',
        'phone',
        'status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $table = 'branches';    

    protected $casts = [
        'id' => 'string'
    ];
    protected $keyType = 'string';
    
    public function users(){

        return $this->belongsToMany(
            'App\Models\User',
            'App\Models\Contract',

        )
        ->where('contracts.status', Contract::ACTIVE);

    }


    public function contract($user_id){

        return $this->users()->attach($user_id ,
            ['id' => Uuid::generate(4)]
        );

    }

    
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }
}
