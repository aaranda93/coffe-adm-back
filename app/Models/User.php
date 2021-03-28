<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Webpatser\Uuid\Uuid;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

use App\Models\Branches;
use App\Models\Contract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, HasRelationships;

    const INACTIVE = 0;
    const ACTIVE = 1;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'surnames',
        'forenames',
        'email',
        'url_pic',
        'url_pic_min',
        'password',
        'nid'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

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

    static function filter(Array $parameters){

        $query = self::select('users.*');

        if(isset($parameters['nid']))
            $query = $query->where(function($query) use($parameters) {
                $query->where(\DB::raw('LOWER(users.nid)'), strtolower($parameters['nid']))
                ->orWhere(\DB::raw('LOWER(users.nid)'), 'like', '%' . strtolower(implode("",explode(".",$parameters['nid']))) . '%');
            });
        
        if(isset($parameters['email'])) 
            $query = $query->where('users.email', $parameters['email']);
            
        if(isset($parameters['status'])) 
            $query = $query->where('users.status', $parameters['status']);

        if(isset($parameters['branch_id'])) 
            $query = $query
            ->join('contracts', 'contracts.user_id', 'users.id')
            ->join('branches', 'branches.id', 'contracs.branch_id')
            ->where('brnaches.id', $parameters['branch_id']);

        if(isset($parameters['company_id'])) 
            $query = $query
            ->join('contracts', 'contracts.user_id', 'users.id')
            ->join('branches', 'branches.id', 'contracs.branch_id')
            ->join('companies', 'companies.id', 'branches.company_id')
            ->where('companies.id', $parameters['company_id']);

        return $query;
    }

    public function branch(){

        return $this->hasOneThrough(
            'App\Models\Branch',
            'App\Models\Contract',
            'user_id',
            'id',
            'id', 
            'branch_id'
        )
        ->where('contracts.status', Contract::ACTIVE)
        ->where('branches.status', Branch::ACTIVE);

    }

    public function company(){

        return $this->hasOneDeep(
            'App\Models\Company', [
                'App\Models\Contract', 
                'App\Models\Branch'
            ],
            [
                'user_id', 
                'id', 
                'id'
             ],
             [
               'id',
               'branch_id',
               'company_id'
             ]
        );

    }

    public function belongsToCompany($company_id){

        try {

            return $this->company()
            ->where('companies.id',$company_id)
            ->firstOrFail();

        } catch (\Exception $th) {
            
            return null;

        }

    }

    public function belongsToBranch($branch_id){
        try {
 
            return $this->company()
            ->where('branches.id',$branch_id)
            ->firstOrFail();

        } catch (\Exception $th) {
            
            return null;

        }

    }

}
