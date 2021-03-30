<?php

namespace App\Models;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use App\Models\Branches;
use App\Models\Product;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Company extends Model
{

    use HasRelationships;


    const INACTIVE = 0;
    const ACTIVE = 1;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nid',
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


    protected $table = 'companies';   

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

    public function products(){

        return $this->HasMany('App\Models\Product')
        ->where('products.status', Product::ACTIVE);
    }

    public function sellsProduct($product_id){

        return (bool)$this->products()
        ->where('products.id', $product_id)
        ->first();
    }

    public function users(){


        return $this->hasOneDeep(
            'App\Models\User', [
                'App\Models\Branch', 
                'App\Models\Contract'
            ],
            [
                'company_id', 
                'branch_id', 
                'id'
             ],
             [
               'id',
               'id',
               'user_id'
             ]
        )
        ->where('contracts.status', Contract::ACTIVE)
        ->where('branches.status', Branch::ACTIVE)
        ->where('users.status', User::ACTIVE);

    }

    public function hasEmploy($user_id){

        return (bool) $this->users()
        ->where('users.id',$user_id)
        ->first();
    }

    
}
