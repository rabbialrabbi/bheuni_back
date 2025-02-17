<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Http\Resources\LeadResource;
use App\Http\Resources\UserResource;
use App\Models\Application;
use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function dashboardData()
    {
        try {
            $user = Auth::user();

            $totalLead = 0;
            $totalApplication = 0;
            $mostActive = 0;
            $isAdmin = 0;

            if($user->role == 'counselor'){
                $totalLead = Lead::where('counselor_id',$user->id)->count();
                $totalApplication = Application::where('user_id',$user->id)->count();
            }else{
                $totalLead = Lead::get()->count();
                $totalApplication = Application::get()->count();
                $startDate = Carbon::now()->subDays(30);
                $endDate = Carbon::now()->endOfDay();
                $mostActive = Application::whereBetween('created_at',[$startDate,$endDate])
                    ->select('user_id', DB::raw('COUNT(*) as application_count'))
                    ->groupBy('user_id')
                    ->orderByDesc('application_count')
                    ->with('counselor')
                    ->first();
                $isAdmin = 1;
            }

            return response()->json(['status' => true, 'data' => [
                'totalLead' => $totalLead,
                'totalApplication' => $totalApplication,
                'mostActive' => $mostActive,
                'isAdmin' => $isAdmin,
            ]]);
        }catch (\Exception $e){
            return response()->json(['status' => false, 'message' => 'Fetch counselor fail','errors'=>$e->getMessage()],500);
        }
    }
}
