<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Todo;
use App\Models\User;
use App\Notifications\CreateTodoSuccessful;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class ApiTodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->check())
        {
            if(auth()->user()->is_admin == 1){
                $todos = Todo::with('project', 'user')->Paginate(10);
            }
            else{
                $userId = auth()->user()->id;
                $todos = Todo::where('user_id', $userId)->with('user', 'project')->paginate(10);
            }
        }
        else{
            return response()->json(['status' => 'error',
            'message' => 'Unauthorized',], 401);
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
                'deadline' => ['required']
            ]);
        }catch(ValidationException $e){

        }

        $data = request()->all();
        $todo = new Todo();

        $todo->name = $data['name'];
        $todo->description = $data['description'];
        $todo->project_id =$data['project_id'];
        $todo->user_id = $data['user_id'];
        $todo->deadline = $data['deadline'];
        $todo->save();
        User::find(Auth::user()->id)->notify(new CreateTodoSuccessful($todo));
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
            isset($data['deadline'])? $todo->deadline =$data['deadline']:$todo->deadline=$todo->deadline;
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

    public function completed(Request $request){
        if(auth()->check())
        {
            if(auth()->user()->is_admin == 1){
                $todos = Todo::with('project', 'user')->where('state', 1)->Paginate(10);
            }
            else{
                $userId = auth()->user()->id;
                $todos = Todo::where('user_id', $userId)->where('state', 1)->with('user', 'project')->paginate(10);
            }
        }
        else{
            return response()->json(['status' => 'error',
            'message' => 'Unauthorized',], 401);
        }
        return response()->json($todos);
    }

    public function inProcess(Request $request){
        if(auth()->check())
        {
            if(auth()->user()->is_admin == 1){
                $todos = Todo::with('project', 'user')->where('state', 0)->Paginate(10);
            }
            else{
                $userId = auth()->user()->id;
                $todos = Todo::where('user_id', $userId)->where('state', 0)->with('user', 'project')->paginate(10);
            }
        }
        else{
            return response()->json(['status' => 'error',
            'message' => 'Unauthorized',], 401);
        }
        return response()->json($todos);
    }

    public function markAsRead(){
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->json(['status'=> 'success',
        'message' => 'Marked as unread',
    ]);
    }

    public function getTodayTask(){
        if(auth()->check())
        {
            if(auth()->user()->is_admin == 1){
                $todos = Todo::with('project', 'user')->whereDate('deadline',now()->today())->Paginate(10);
            }
            else{
                $userId = auth()->user()->id;
                $todos = Todo::where('user_id', $userId)->whereDate('deadline',now()->today())->with('user', 'project')->paginate(10);
            }
        }
        else{
            return response()->json(['status' => 'error',
            'message' => 'Unauthorized',], 401);
        }
        return response()->json($todos);
    }


    public function search(Request $request){
        if(auth()->check())
        {
            if ($request->has('page') && (!$request->has('search_box') || !$request->has('selection'))) {
                return response()->json(['status' => 'error',
                'message' => 'Invalid pagination request. Please provide search criteria.',], 400);
            }
            switch ($request->selection) {
                case 'user_name':
                {
                    if(auth()->user()->is_admin == 1){
                        $user_id = User::where('name',$request->search_box)->value('id');
                        $todos = Todo::with('project', 'user')->where('user_id', $user_id)->paginate(10);
                    }
                    else{
                        return response()->json(['status' => 'error',
                        'message' => 'Unauthorized',], 401);
                    }
                }
                break;
                case 'task_name':
                {
                    if(auth()->user()->is_admin == 1){
                        $todos = Todo::with('project', 'user')->where('name', $request->search_box)->paginate(10);
                    }
                    else{
                        $user_id = auth()->user()->id;
                        return $todos = Todo::where('user_id', $user_id)->where('name', $request->search_box)->with('project', 'user')->paginate(10);
                    }
                }
                break;
                case 'project_name':
                {
                    $project_id = Project::where('name', $request->search_box)->value('id');
                    $todos = Todo::with('project', 'user')->where('project_id', $project_id)->paginate(10);
                }
                break;
                default:
                {
                    return response()->json(['status' => 'error',
                    'message' => 'check your selection',], 401);
                }
            }
        }
        else{
            return response()->json(['status' => 'error',
            'message' => 'Unauthorized',], 401);
        }
        return response()->json($todos);
    }
}
