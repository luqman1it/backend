<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Project;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use League\Flysystem\Visibility;
use App\Http\Requests\StorProject;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\StoreFileTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UpdateProject;
use App\Models\Contact;
use App\Models\Skill;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    use StoreFileTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $projects = Project::with('type')->get();

        return response()->json([
            'status'=>'success',
            'projects'=>$projects
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorProject $request)
    {
        DB::beginTransaction();
        try {



            $project =Project::create([
                'name'=>$request->name,
                'description'=>$request->description,
                'img_url'=>$this->storeFile($request->img_url,'project'),
                'type_id'=>$request->type_id,
                'link'=>$request->link
            ]);
         if($request->skill_id){
            $project->skills()->attach($request->skill_id);
         }
            DB::commit();
            return response()->json([
                'status'=>'success',
                'project'=>$project,
                'skill'=>$project->skills
            ]);


        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'status'=>'error',
                'message'=>$e->getMessage()
            ]);
        }




    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $projects=$project->with('type')->get();
        return response()->json([
            'status'=>'success',
            'project'=>$projects,
            'skill'=>$projects->skills


        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProject $request, Project $project)
    {

        try {
            DB::beginTransaction();
            $projectData=[];
            if(isset($request->name)){

               $projectData['name']=$request->name;}

            if(isset($request->description)){
              $projectData['description']=$request->description;}

              if(isset($request->img_url)){
                $newData['img_url']=$request->img_url?$this->StoreFile($request->img_url,'project'):$project->img_url;
            }

            if(isset($request->type_id)){
              $projectData['type_id']=$request->type_id;}

            if(isset($request->link)){
              $projectData['link']=$request->link;}
              //update many to many

              if($request->skill_id){
                $project->skills()->sync($request->skill_id);
             }
            $project->update($projectData);
            DB::commit();

            return response()->json([
                'status'=>'success',
                'project'=>$project,
            ]);


        } catch (\Throwable $e) {
            DB::rollBack();
            log::error($e->getMessage());
            return response()->json([
                'status'=>'error',
                'message'=>$e->getMessage()
            ]);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if($project->skills){
            $project->skills()->detach();
            $project->delete();
            return response()->json([
                'status'=>'success',
                'message'=>'Project and skill'
            ]);

        }else{
            $project->delete();
            return response()->json([
                'status'=>'success',
                'message'=>'Project deleted'
            ]);
        }}


        public function count(){
            $projects=Project::count();
            $skills=Skill::count();
            $Messages=Contact::count();
            return response()->json([
                'count'=>[
                'projects'=>$projects,
                'skills'=>$skills,
                'Messages'=>$Messages]


            ]);
    }
}
