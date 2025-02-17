<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Http\Requests\UpdateLeadStatusRequest;
use App\Http\Resources\LeadResource;
use App\Models\Application;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_unless(Gate::allows('lead:view'), 401);

        $use = Auth::user();
        $filters = $request->only(['q', 'itemsPerPage', 'sortBy']);

        $itemPerPage = $filters['itemsPerPage']??10;
        $query = Lead::where('status','>',0);

        if($use->role == 'counselor'){
            $query = $query->where('counselor_id',$use->id);
        }

        if(!empty($filters['q'])){
            $key = $filters['q'];
            $query =  $query->where(function ($query) use ($key) {
                $query->where('name', 'like', '%'.$key.'%');
                $query->orWhere('email', 'like', '%'.$key.'%');
            });
        }

        if (!empty($filters['sortBy'][0]) && !empty($filters['sortBy'][0]['key']) && !empty($filters['sortBy'][0]['order'])) {
            $sortBy = $filters['sortBy'][0]['key'];
            $orderBy = $filters['sortBy'][0]['order'];

            $query->orderBy($sortBy, $orderBy);

        }

        $paginateData = $query->paginate($itemPerPage);

        return LeadResource::collection($paginateData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        try {
            abort_unless(Gate::allows('lead:assign'), 401);

            $request->validated();
            $lead->update([
                'counselor_id'=> $request->counselor_id,
            ]);
            return  response()->json(['status'=>true,'message' => 'Assigned counselor successfully']);

        }catch (\Exception $e){
            return response()->json(['status'=>false,'message' => 'Something went wrong','errors'=>$e->getMessage()], 500);
        }
    }

    public function status(UpdateLeadStatusRequest $request,Lead $lead)
    {
        try {
            abort_unless(Gate::allows('lead-status:change'), 401);

            $request->validated();
            $lead->update(['status' => $request->status]);
            return  response()->json(['status'=>true,'message' => 'Update lead status successfully']);
        }catch (\Exception $e){
            return response()->json(['status'=>false,'message' => 'Update lead status fail','errors'=>$e->getMessage()], 500);
        }
    }
    public function application(Lead $lead)
    {
        try {

            abort_unless(Gate::allows('lead-application:move'), 401);

            $isExist = Application::where('lead_id',$lead->id)->count();
            if(!$isExist){
                Application::create([
                    'name'=> $lead->name,
                    'email'=> $lead->email,
                    'phone'=> $lead->phone,
                    'lead_id'=> $lead->id,
                    'user_id'=> $lead->counselor_id??Auth::user()->id,
                    'status'=> 2,
                ]);

                $lead->update(['status'=>0]);
            }

            return  response()->json(['status'=>true,'message' => 'Update lead status successfully']);
        }catch (\Exception $e){
            return response()->json(['status'=>false,'message' => 'Update lead status fail','errors'=>$e->getMessage()], 500);
        }
    }
}
