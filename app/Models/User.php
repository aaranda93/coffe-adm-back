<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

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

/*     public function branch(){

        return $this->belongsToMany('App\Branch','contracts');

    } */
}
