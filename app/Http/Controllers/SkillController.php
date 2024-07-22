<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SkillRequest;
use App\Http\Traits\StoreFileTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UpdateSkillRequest;

class SkillController extends Controller
{
    use StoreFileTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $skills=Skill::all();
        return response()->json([
           'status'=>'list of skills',
           'skills'=>$skills
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SkillRequest $request)
    {
        //
        try{
        DB::beginTransaction();

          $skill=Skill::create([
            'name' =>$request->name,
            'image'  =>$this->storeFile($request->image,'skill')
          ]);
          DB::commit();
          return response()->json([
            'status'=>'Add skill',
            'skill'=>$skill
          ]);
        }
        catch(Throwable $th){
            DB::rollback();
            Log::debug($th);
            $e = Log::error($th->getMessage());

            return response()->json([
                'status' => 'error',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        //
        return response()->json([
            'status'=>'show',
            'skill'=>$skill
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkillRequest $request, Skill $skill)
    {
        //
        try{

            DB::beginTransaction();
            $newData=[];
            if(isset($request->name)){
                $newData['name']=$request->name;
            }
            if(isset($request->image)){
                $newData['image']=$request->image?$this->StoreFile($request->image,'skill'):$skill->image;
            }
            $skill->update($newData);
            DB::commit();
            return response()->json([
                'status'=>'update skill',
                'skill'=>$skill
              ]);
        }catch(\Throwable $th){
            DB::rollback();
            Log::debug($th);
            $e = Log::error($th->getMessage());

            return response()->json([
                'status' => 'error',
            ]);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        //
        $skill->delete();
        return response()->json([
            'status'=>'delete'
        ]);
    }
}
