<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'home' => [
                'home:view' => 'Home View',
            ],
            'lead' => [
                'lead:view' => 'Lead View',
                'lead:assign' => 'Lead Assign',
                'lead-status:change' => 'Lead Status Change',
                'lead-application:move' => 'Lead move to application',
            ],
            'application' => [
                'application:view' => 'application View',
                'application-status:change' => 'application Status Change',
            ],
        ];

        foreach ($permissions as $title=>$value){
            foreach ($value as $slug=>$name){
                Permission::create(['name' => $name, 'slug' => $slug, 'section' => $title,]);
            }
        }
    }

}
