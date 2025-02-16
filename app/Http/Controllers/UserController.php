<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Http\Resources\LeadResource;
use App\Http\Resources\UserResource;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $counselor = User::where('role', 'counselor')->get();

            return UserResource::collection($counselor);

        }catch (\Exception $e){
            return response()->json(['status' => false, 'message' => 'Fetch counselor fail','errors'=>$e->getMessage()],500);
        }

    }
}
