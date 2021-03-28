<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'superadmin'
            ],
            [
                'id' => 2,
                'name' => 'owner'
            ],
            [
                'id' => 3,
                'name' => 'admin'
            ],
            [
                'id' => 4,
                'name' => 'waiter'
            ],
            [
                'id' => 5,
                'name' => 'cashier'
            ],

        ];


        Role::insert($roles);
        
    }
}
