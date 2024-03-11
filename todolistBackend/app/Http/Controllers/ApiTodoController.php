<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Todo;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class ApiTodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->check())
        {
            if(auth()->user()->is_admin == 1){
                $todos = Todo::with('project', 'user')->get();
            }
            else{
                $userId = auth()->user()->id;
                $todos = Todo::where('user_id', $userId)->with('user', 'project')->get();
            }
        }
        else{
            $todos = Todo::with('project', 'user')->get();
        }
        return response()->json($todos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $this->validate(request(),[
                'name' => ['required'],
                'description' => ['required'],
                'project_id' => ['required'],
                'user_id' => ['required'],
            ]);
        }catch(ValidationException $e){

        }

        $data = request()->all();
        $todo = new Todo();

        $todo->name = $data['name'];
        $todo->description = $data['description'];
        $todo->project_id =$data['project_id'];
        $todo->user_id = $data['user_id'];
        $todo->save();

        return response()->json($data['name']. ' is added');
    }

    /**
     * Display the user, project select list resource in create todo page.
     */
    public function createData(){
        return $data =[
            'projects' => $project = Project::all(),
            'users' => $user = User::all()
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $detailsTodo = Todo::with('project')->find($request->id);
        if(isset($detailsTodo))
        return response()->json($detailsTodo);
        else{
            return 'To do does not exist in the database';
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        try{
            $this->validate(request(),[
                'id' => ['required'],
            ]);
        }catch(ValidationException $e){

        }

        if(Todo::find($request['id']))
        {
            $todo = Todo::find($request['id']);
            $data = request()->all();
            isset($data['name'])? $todo->name = $data['name']:$todo->name = $todo->name;
            isset($data['description'])? $todo->description = $data['description']:$todo->description=$todo->description;
            isset($data['state'])? $todo->state = $data['state']:$todo->state=$todo->state;
            isset($data['project_id'])? $todo->project_id = $data['project_id']: $todo->project_id=$todo->project_id;
            isset($data['user_id'])? $todo->user_id =$data['user_id']:$todo->user_id=$todo->user_id;
            $todo->save();
            return response($todo);
        }
        else{
            return response('Can find the task you want');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if(Todo::find($request->id))
        {
            Todo::find($request->id)->delete();
            return response('Todo is deleted');
        }
        else{
            return response("todo doesn't exist");
        }
    }
}
