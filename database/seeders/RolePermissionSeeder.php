<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permission_role')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
        ]);

        /* Assign role to user*/
        $users = User::get();

        foreach ($users as $user) {
            if($user->role == 'admin'){
                $user->assignRole('super-admin');
            }elseif($user->role == 'counselor'){
                $user->assignRole('counselor');
            }
        }

        /*Assign Permission to Roles*/
        $this->giveAllPermissionToSuperAdmin();
        $this->giveAllPermissionToCounselor();
    }


    private function giveAllPermissionToSuperAdmin()
    {
        /* Assign role permissions to Super Admin for admin panel*/
        $permissions = Permission::get();
        $permissions->each(function ($permission) {
            $roleAdmin = Role::where('slug', 'super-admin')->first();
            $roleAdmin->givePermissionTo($permission);
        });
    }

    private function giveAllPermissionToCounselor()
    {
        $counselorPermission = [
            'home:view',
            'lead:view',
            'lead-status:change',
            'lead-application:move',
            'application:view',
            'application-status:change',
        ];

        /* Assign role permissions to Super Admin for admin panel*/
        $permissions = Permission::whereIn('slug',$counselorPermission)->get();
        $permissions->each(function ($permission) {
            $roleAdmin = Role::where('slug', 'counselor')->first();
            $roleAdmin->givePermissionTo($permission);
        });
    }
}
