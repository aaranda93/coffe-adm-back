<?php

namespace App\Models;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use App\Models\ContractRole;

class Contract extends Model
{
    const INACTIVE = 0;
    const ACTIVE = 1;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'branch_id',
        'status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $table = 'contracts';    

    protected $casts = [
        'id' => 'string'
    ];

    protected $keyType = 'string';
    
    public function roles(){

        return $this->belongsToMany(
            'App\Models\Role',
            'App\Models\ContractRole',

        )
        ->where('contract_role.status', ContractRole::ACTIVE);

    }

    public function addRole($role_id){

        return $this->roles()->attach($role_id ,
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
