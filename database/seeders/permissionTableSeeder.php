<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class permissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'section-list',
            'section-create',
            'section-edit',
            'section-delete',
            'invoice-list',
            'invoice-create',
            'invoice-edit',
            'invoice-delete',
        ];
        foreach ($permissions as $permission){
            Permission::create(['name' => $permission]);

        }
    }
}
