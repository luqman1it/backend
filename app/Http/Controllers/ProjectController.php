<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorProject;
use App\Http\Requests\UpdateProject;
use App\Models\Project;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\Visibility;

class ProjectController extends Controller
{
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

            $file = $request->img_url;
            $originalName = $file->getClientOriginalName();

             // Check for double extensions in the file name
             if (preg_match('/\.[^.]+\./', $originalName)) {
                throw new Exception(trans('general.notAllowedAction'), 403);
            }


            $storagePath = Storage::disk('public')->put('images', $file, [
                'visibility' => Visibility::PUBLIC
            ]);


            $project =Project::create([
                'name'=>$request->name,
                'description'=>$request->description,
                'img_url'=>$storagePath,
                'type_id'=>$request->type_id,
                'link'=>$request->link
            ]);

            DB::commit();

            return response()->json([
                'status'=>'success',
                'project'=>$project
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

        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProject $request, Project $project)
    {
        DB::beginTransaction();
        $projectData=[];
        try {
            if(isset($request->name)){

               $projectData['name']=$request->name;}

            if(isset($request->description)){
              $projectData['description']=$request->description;}

            if(isset($request->img_url)){

              $file = $request->img_url;
              $originalName = $file->getClientOriginalName();

               // Check for double extensions in the file name
               if (preg_match('/\.[^.]+\./', $originalName)) {
                  throw new Exception(trans('general.notAllowedAction'), 403);
            }
            $storagePath = Storage::disk('public')->put('images', $file, [
                'visibility' => Visibility::PUBLIC
            ]);
            $projectData['img_url']=$storagePath;
        }

            if(isset($request->type_id)){
              $projectData['type_id']=$request->type_id;}

            if(isset($request->link)){
              $projectData['link']=$request->link;}

            $project->update($projectData);
            DB::commit();

            return response()->json([
                'status'=>'success',
                'project'=>$projectData
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
        $project->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'Project deleted'
        ]);
    }
}
