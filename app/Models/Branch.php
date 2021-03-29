<?php

namespace App\Models;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\Contract;

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

    public function hasEmploy($user_id){

        return (bool) $this->users()
        ->where('users.id',$user_id)
        ->first();
    }


    public function contract($user_id, $isOwner = false){

        try {

            $this->users()->attach($user_id ,
                ['id' => $contract_id = Uuid::generate(4)]
            );

            if($isOwner){
                
                $contract = Contract::findorfail($contract_id);
                $contract->addRole(Role::OWNER);

            }

            return;

        } catch (\Exception $th) {

            throw $th;

        }



    }

    
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }
}
