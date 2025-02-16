<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Http\Requests\UpdateLeadStatusRequest;
use App\Http\Resources\LeadResource;
use App\Models\Application;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $filters = $request->only(['q', 'itemsPerPage', 'sortBy']);

        $itemPerPage = $filters['itemsPerPage']??10;
        $query = Lead::where('status','>',0);

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeadRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        try {
            $request->validated();
            $lead->update([
                'counselor_id'=> $request->counselor_id,
            ]);
            return  response()->json(['status'=>true,'message' => 'Assigned counselor successfully']);

        }catch (\Exception $e){
            return response()->json(['status'=>false,'message' => 'Something went wrong','errors'=>$e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        //
    }

    public function status(UpdateLeadStatusRequest $request,Lead $lead)
    {
        try {
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

            $isExist = Application::where('lead_id',$lead->id)->count();
            if(!$isExist){
                Application::create([
                    'name'=> $lead->name,
                    'email'=> $lead->email,
                    'phone'=> $lead->phone,
                    'lead_id'=> $lead->id,
                    'user_id'=> $lead->counselor_id,
                ]);

                $lead->update(['status'=>0]);
            }

            return  response()->json(['status'=>true,'message' => 'Update lead status successfully']);
        }catch (\Exception $e){
            return response()->json(['status'=>false,'message' => 'Update lead status fail','errors'=>$e->getMessage()], 500);
        }
    }
}
