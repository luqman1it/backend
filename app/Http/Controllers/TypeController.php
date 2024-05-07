<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorType;
use App\Http\Requests\UpdateType;
use App\Models\Type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::with('Projects')->get();
        return response()->json([
            'status'=>'success',
            'types'=>$types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorType $request)
    {
        DB::beginTransaction();
        try{
            $type=Type::create([
                'name'=>$request->name
            ]);
            DB::commit();
            return response()->json([
                'status'=>'success',
                'message'=>'Type created successfully',
                'type'=>$type
            ]);

        }
        catch(\Throwable $e){

            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'status'=>'error',
                'message'=>'Type not created'
            ]);
        }



    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        $types=$type->with('projects')->get();
        return response()->json([
            'status'=>'success',
            'types'=>$types
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateType $request, Type $type)
    {
        DB::beginTransaction();
        try{
            $type->update([
                'name'=>$request->name
            ]);
            DB::commit();
            return response()->json([
                'status'=>'success',
                'message'=>'Type updated successfully',
                'type'=>$type
            ]);

        }
        catch(\Throwable $e){

            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'status'=>'error',
                'message'=>'Type not updated'
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'Type deleted successfully'
        ]);
    }
}
