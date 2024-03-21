<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class ApiProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index(){
        if(auth()->user()->is_admin == 1){
            return Project::paginate(10);
        }
        else{
            return response()->json(['status' => 'error',
            'message' => 'Unauthorized',], 401);
        }
    }

    public function store(Request $request){
        try{
            $this->validate(request(),[
                'name' => ['required'],
            ]);
        }catch(ValidationException $e){

        }
        $data = request()->all();
        $project = new Project();

        $project->name = $data['name'];
        $project->save();
        return response()->json($project);
    }

    public function destroy(Request $request){
        try{
            $this->validate(request(),[
                'id' => ['required'],
            ]);
        }catch(ValidationException $e){

        }

        if(Project::find($request->id))
        {
            Project::find($request->id)->delete();
            return response('Project is deleted');
        }
        else{
            return response("Project doesn't exist");
        }
    }
}
