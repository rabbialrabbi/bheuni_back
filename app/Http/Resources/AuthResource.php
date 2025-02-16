<?php

namespace App\Http\Resources;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $token = $this->createToken($this->name.'-AuthToken')->plainTextToken;
        return [
            'user' => UserResource::make($this),
            'token' => $token,
            'permissions' => $this->userPermissions()

        ];
    }

    public function userPermissions()
    {
        $permissions = Permission::with('roles')->get();

        $userPermission = [];
        foreach ($permissions as $k=>$permission) {
            if($this->hasRole($permission->roles)){
                $p = explode(':',$permission->slug);
                if(count($p) == 2){
                    $userPermission[$k]['subject'] = $p[0];
                    $userPermission[$k]['action'] = $p[1];
                }
            }
        }

        return $userPermission;
    }
}
