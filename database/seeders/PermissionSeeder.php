<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'lead' => [
                'lead:view' => 'Lead View',
                'lead:create' => 'Lead Create',
                'lead:assign' => 'Lead Assignments',
            ],
        ];

        foreach ($permissions as $title=>$value){
            foreach ($value as $slug=>$name){
                Permission::create(['name' => $name, 'slug' => $slug, 'section' => $title,]);
            }
        }
    }

}
