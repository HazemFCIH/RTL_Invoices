<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([

            'name' => 'demo admin',
            'email' => 'demo@demo.com',
            'password'=> bcrypt('demo_pass'),
            'roles_name' => '[Owner]',
            'status' => 'مفعل',
        ]);
        $role = Role::create([
            'name' => 'Owner'
        ]);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
