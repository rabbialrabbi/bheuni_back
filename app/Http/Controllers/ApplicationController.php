<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            abort_unless(Gate::allows('application:view'), 401);
            $use = Auth::user();
            $filters = $request->only(['q', 'itemsPerPage', 'sortBy']);

            $itemPerPage = $filters['itemsPerPage']??10;
            $query = Application::where('user_id',$use->id);

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

            return ApplicationResource::collection($paginateData);
        }catch (\Exception $e){
            return response()->json(['status'=>false,'message' => 'Fetch application fail','errors'=>$e->getMessage()], 500);

        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        try {
            abort_unless(Gate::allows('application-status:change'), 401);
            $request->validated();
            $application->update(['status' => $request->status]);
            return  response()->json(['status'=>true,'message' => 'Update application status successfully']);
        }catch (\Exception $e){
            return response()->json(['status'=>false,'message' => 'Update application status fail','errors'=>$e->getMessage()], 500);
        }
    }
}
