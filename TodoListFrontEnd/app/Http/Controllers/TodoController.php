<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTimeZone;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TodoController extends Controller
{
    public function index(){

        // handling token and user authentication
        $token = session('token');
        $user = session('user');
        if($token == null){
            return 'token is null';
        }
        if($user == null){
            return 'user is null';
        }
        $is_loggedIn = true;
        // end


        $todosWithPage = Http::withToken($token)->get('http://localhost:8008/api/serve/index')->json();
        $todos = null;
        $todoswithOutTimeLeft = $todosWithPage['data'];


        foreach($todoswithOutTimeLeft as $todo){
            $startDate = Carbon::now();
            $endDate = Carbon::parse($todo['deadline']);
            if($startDate->gt($endDate)){
                $timeLeft = [ 'days' => 0, 'hours' => 0, 'minutes' => 0, 'totalMinutes' => 0 ];
            }
            else{
                $totalMinutesLeft = $startDate->diffInMinutes($endDate);
                if($totalMinutesLeft <= 0){
                    $timeLeft = [ 'days' => 0, 'hours' => 0, 'totalMinutes' => 0, 'minutes' => 0];
                }
                elseif($totalMinutesLeft < 60){
                    $timeLeft = [ 'days' => 0, 'hours' => 0, 'minutes' => $totalMinutesLeft, 'totalMinutes' => $totalMinutesLeft];
                }
                elseif($totalMinutesLeft < 1440){
                    $timeLeft = [ 'days' => 0, 'hours' => floor($totalMinutesLeft/60), 'minutes' => fmod($totalMinutesLeft, 60),'totalMinutes' => $totalMinutesLeft];
                }
                else{
                    $days = floor($totalMinutesLeft/1440);//1505/1440 = 1
                    $minutesafterday = $totalMinutesLeft - $days*1440;//1505 - 1*1440 = 65
                    $hours = floor($minutesafterday/60);// 65/60 = 1
                    $minutesafterhour = $minutesafterday - $hours*60; //65 - 1*60 = 5
                    $timeLeft = [ 'days' => $days, 'hours' => $hours , 'minutes' => $minutesafterhour, 'totalMinutes' => $totalMinutesLeft];
                }
            }
            $todo['timeleft'] = $timeLeft;
            $todos[] = $todo;

        }
        $paginationLinks = $todosWithPage['links'];
        $numberOfPage = $todosWithPage['last_page'];
        $data = Http::withToken($token)->get('http://localhost:8008/api/serve/createData')->json();
        return view('index', compact('todos', 'paginationLinks','numberOfPage', 'todosWithPage', 'data', 'is_loggedIn', 'user'));
    }

    public function indexPage(Request $request){
        // handling token and user authentication
        $token = session('token');
        $user = session('user');
        if($token == null){
            return 'token is null';
        }
        if($user == null){
            return 'user is null';
        }
        $is_loggedIn = true;
        // end

        // the link to the page that the user has just clicked.
        if( strpos(array_key_first($request->all()), 'search') ){
            $links = $request->all();
            $link = "";
            $first = true;
            foreach ($links as $key => $value) {
            $link .= ($first ? '' : '&') . $key . '=' . urlencode($value);
            $first = false;
            }
        }
        else{
            $link = key($request->all()).'='.implode($request->all());
        }
        //fetch the data for the page the user clicked
        $todosWithPage = Http::withToken($token)->get($link)->json();


        //adding timeleft to $todos
        $todoswithOutTimeLeft = $todosWithPage['data'];

        foreach($todoswithOutTimeLeft as $todo){
            $startDate = Carbon::now();
            $endDate = Carbon::parse($todo['deadline']);
            if($startDate->gt($endDate)){
                $timeLeft = [ 'days' => 0, 'hours' => 0, 'minutes' => 0, 'totalMinutes' => 0 ];
            }
            else{
                $totalMinutesLeft = $startDate->diffInMinutes($endDate);
                if($totalMinutesLeft <= 0){
                    $timeLeft = [ 'days' => 0, 'hours' => 0, 'totalMinutes' => 0, 'minutes' => 0];
                }
                elseif($totalMinutesLeft < 60){
                    $timeLeft = [ 'days' => 0, 'hours' => 0, 'minutes' => $totalMinutesLeft, 'totalMinutes' => $totalMinutesLeft];
                }
                elseif($totalMinutesLeft < 1440){
                    $timeLeft = [ 'days' => 0, 'hours' => floor($totalMinutesLeft/60), 'minutes' => fmod($totalMinutesLeft, 60),'totalMinutes' => $totalMinutesLeft];
                }
                else{
                    $days = floor($totalMinutesLeft/1440);//1505/1440 = 1
                    $minutesafterday = $totalMinutesLeft - $days*1440;//1505 - 1*1440 = 65
                    $hours = floor($minutesafterday/60);// 65/60 = 1
                    $minutesafterhour = $minutesafterday - $hours*60; //65 - 1*60 = 5
                    $timeLeft = [ 'days' => $days, 'hours' => $hours , 'minutes' => $minutesafterhour, 'totalMinutes' => $totalMinutesLeft];
                }
            }
            $todo['timeleft'] = $timeLeft;
            $todos[] = $todo;
        }

        $paginationLinks = $todosWithPage['links'];
        $numberOfPage = $todosWithPage['last_page'];
        $data = Http::withToken($token)->get('http://localhost:8008/api/serve/createData')->json();
        return view('index', compact('todos', 'paginationLinks', 'numberOfPage', 'todosWithPage', 'data', 'is_loggedIn', 'user'));
    }

    public function destroy($id){
        $token = session('token');
        if($token == null){
            return 'token is null';
        }
        $response = Http::withToken($token)->post('http://localhost:8008/api/serve/delete',[
            'id' => $id,
            '_method' => 'delete'
        ]);
        notify()->success('Task deleted');
        return redirect()->back();
    }

    public function create(){
        $token = session('token');
        $user = session('user');
        if($token == null){
            return 'token is null';
        }
        $is_loggedIn = true;
        $data = Http::withToken($token)->get('http://localhost:8008/api/serve/createData')->json();
        return view('create', compact('data', 'is_loggedIn', 'user'));
    }

    public function store(){
        try{
            $this->validate(request(),[
                'name' => ['required'],
                'description' =>['required'],
                'project_id' =>['required'],
                'user_id' =>['required'],
            ]);
        }catch(ValidationException $e){

        }

        $token = session('token');
        if($token == null){
            return 'token is null';
        }

        $data = request()->all();
        // return $data;
        Http::withToken($token)->post('http://localhost:8008/api/serve/store',[
            'name' => $data['name'],
            'description' => $data['description'],
            'project_id' => $data['project_id'],
            'user_id' => $data['user_id'],
            'deadline' => $data['deadline']
        ]);
        notify()->success('Task successfully created');
        return redirect()->back();
    }

    public function update(){
        try{
            $this->validate(request(),[
                'id' => ['required'],
            ]);
        }catch(ValidationException $e){

        }
        $token = session('token');
        if($token == null){
            return 'token is null';
        }
        $data=request()->all();
        $data['_method'] = 'patch';
        unset($data['_token']);
        Http::withToken($token)->patch('http://localhost:8008/api/serve/update',$data);
        notify()->success('Task successfully updated');
        return redirect()->back();
    }

    public function loginPage(){
        return view('login');
    }

    public function registerPage(){
        return view('register');
    }

    public function register(){
        try{
            $this->validate(request(),[
                'email' => ['required'],
                'name' => ['required'],
                'password' => ['required']
            ]);
        }catch(ValidationException $e){

        }

        $data = request()->all();
        Http::post('http://localhost:8008/api/register', $data);
        notify()->success('Register successfully, please login');
        return redirect('api/login');
    }

    public function login(){
        try{
            $this->validate(request(),[
                'email' => ['required'],
                'password' => ['required']
            ]);
        }catch(ValidationException $e){

        }

        $data = ['email'=>request('email'),
            'password'=>request('password')
        ];

        $response = Http::post('http://localhost:8008/api/login', $data);
        session()->start();
        if($response['status'] == 'success'){
            //set token session
            $token = $response->json()['authorisation']['token'];
            session(['token' => $token ]);
            //set user session
            $user = $response->json()['user'];
            session(['user' => $user]);
            notify()->success('Login successfully');
            // notify()->preset('user-deleted');

            return redirect('api/index');
        }
        else{
            return redirect()->back()->withErrors(['login' => 'Login failed. Please try again.']);
        }
    }

    public function logout(){
        $token = session('token');
        $user = null;
        if($token == null){
            return 'token is null';
        }
        $is_loggedIn = false;

        Http::withToken($token)->post('http://localhost:8008/api/logout');

        return redirect('api/login');
    }

    public function completed(){
        $token = session('token');
        $user = session('user');
        if($token == null){
            return 'token is null';
        }
        if($user == null){
            return 'user is null';
        }
        $is_loggedIn = true;
        // end


        $todosWithPage = Http::withToken($token)->get('http://localhost:8008/api/serve/completed')->json();
        $todos = null;
        $todoswithOutTimeLeft = $todosWithPage['data'];

        foreach($todoswithOutTimeLeft as $todo){
            $startDate = Carbon::now();
            $endDate = Carbon::parse($todo['deadline']);
            if($startDate->gt($endDate)){
                $timeLeft = [ 'days' => 0, 'hours' => 0, 'minutes' => 0, 'totalMinutes' => 0 ];
            }
            else{
                $totalMinutesLeft = $startDate->diffInMinutes($endDate);
                if($totalMinutesLeft <= 0){
                    $timeLeft = [ 'days' => 0, 'hours' => 0, 'totalMinutes' => 0, 'minutes' => 0];
                }
                elseif($totalMinutesLeft < 60){
                    $timeLeft = [ 'days' => 0, 'hours' => 0, 'minutes' => $totalMinutesLeft, 'totalMinutes' => $totalMinutesLeft];
                }
                elseif($totalMinutesLeft < 1440){
                    $timeLeft = [ 'days' => 0, 'hours' => floor($totalMinutesLeft/60), 'minutes' => fmod($totalMinutesLeft, 60),'totalMinutes' => $totalMinutesLeft];
                }
                else{
                    $days = floor($totalMinutesLeft/1440);//1505/1440 = 1
                    $minutesafterday = $totalMinutesLeft - $days*1440;//1505 - 1*1440 = 65
                    $hours = floor($minutesafterday/60);// 65/60 = 1
                    $minutesafterhour = $minutesafterday - $hours*60; //65 - 1*60 = 5
                    $timeLeft = [ 'days' => $days, 'hours' => $hours , 'minutes' => $minutesafterhour, 'totalMinutes' => $totalMinutesLeft];
                }

            }
            $todo['timeleft'] = $timeLeft;
            $todos[] = $todo;
        }
        $paginationLinks = $todosWithPage['links'];
        $numberOfPage = $todosWithPage['last_page'];
        $data = Http::withToken($token)->get('http://localhost:8008/api/serve/createData')->json();
        return view('index', compact('todos', 'paginationLinks','numberOfPage', 'todosWithPage', 'data', 'is_loggedIn', 'user'));
    }


    public function inProcess(){
        $token = session('token');
        $user = session('user');
        if($token == null){
            return 'token is null';
        }
        if($user == null){
            return 'user is null';
        }
        $is_loggedIn = true;
        // end

        $todosWithPage = Http::withToken($token)->get('http://localhost:8008/api/serve/inprocess')->json();
        $todos = null;
        $todoswithOutTimeLeft = $todosWithPage['data'];

        foreach($todoswithOutTimeLeft as $todo){
            $startDate = Carbon::now();
            $endDate = Carbon::parse($todo['deadline']);
            if($startDate->gt($endDate)){
                $timeLeft = [ 'days' => 0, 'hours' => 0, 'minutes' => 0, 'totalMinutes' => 0 ];
            }
            else{
                $totalMinutesLeft = $startDate->diffInMinutes($endDate);
                if($totalMinutesLeft <= 0){
                    $timeLeft = [ 'days' => 0, 'hours' => 0, 'totalMinutes' => 0, 'minutes' => 0];
                }
                elseif($totalMinutesLeft < 60){
                    $timeLeft = [ 'days' => 0, 'hours' => 0, 'minutes' => $totalMinutesLeft, 'totalMinutes' => $totalMinutesLeft];
                }
                elseif($totalMinutesLeft < 1440){
                    $timeLeft = [ 'days' => 0, 'hours' => floor($totalMinutesLeft/60), 'minutes' => fmod($totalMinutesLeft, 60),'totalMinutes' => $totalMinutesLeft];
                }
                else{
                    $days = floor($totalMinutesLeft/1440);//1505/1440 = 1
                    $minutesafterday = $totalMinutesLeft - $days*1440;//1505 - 1*1440 = 65
                    $hours = floor($minutesafterday/60);// 65/60 = 1
                    $minutesafterhour = $minutesafterday - $hours*60; //65 - 1*60 = 5
                    $timeLeft = [ 'days' => $days, 'hours' => $hours , 'minutes' => $minutesafterhour, 'totalMinutes' => $totalMinutesLeft];
                }
            }
            $todo['timeleft'] = $timeLeft;
            $todos[] = $todo;
        }
        $paginationLinks = $todosWithPage['links'];
        $numberOfPage = $todosWithPage['last_page'];
        $data = Http::withToken($token)->get('http://localhost:8008/api/serve/createData')->json();
        return view('index', compact('todos', 'paginationLinks','numberOfPage', 'todosWithPage', 'data', 'is_loggedIn', 'user'));
    }

    public function getTodayTask(){
        $token = session('token');
        $user = session('user');
        if($token == null){
            return 'token is null';
        }
        if($user == null){
            return 'user is null';
        }
        $is_loggedIn = true;
        // end

        $todosWithPage = Http::withToken($token)->get('http://localhost:8008/api/serve/todaytask')->json();
        $todos = null;
        $todoswithOutTimeLeft = $todosWithPage['data'];

        foreach($todoswithOutTimeLeft as $todo){
            $startDate = Carbon::now();
            $endDate = Carbon::parse($todo['deadline']);
            if($startDate->gt($endDate)){
                $timeLeft = [ 'days' => 0, 'hours' => 0, 'minutes' => 0, 'totalMinutes' => 0 ];
            }
            else{
                $totalMinutesLeft = $startDate->diffInMinutes($endDate);
                if($totalMinutesLeft <= 0){
                    $timeLeft = [ 'days' => 0, 'hours' => 0, 'totalMinutes' => 0, 'minutes' => 0];
                }
                elseif($totalMinutesLeft < 60){
                    $timeLeft = [ 'days' => 0, 'hours' => 0, 'minutes' => $totalMinutesLeft, 'totalMinutes' => $totalMinutesLeft];
                }
                elseif($totalMinutesLeft < 1440){
                    $timeLeft = [ 'days' => 0, 'hours' => floor($totalMinutesLeft/60), 'minutes' => fmod($totalMinutesLeft, 60),'totalMinutes' => $totalMinutesLeft];
                }
                else{
                    $days = floor($totalMinutesLeft/1440);//1505/1440 = 1
                    $minutesafterday = $totalMinutesLeft - $days*1440;//1505 - 1*1440 = 65
                    $hours = floor($minutesafterday/60);// 65/60 = 1
                    $minutesafterhour = $minutesafterday - $hours*60; //65 - 1*60 = 5
                    $timeLeft = [ 'days' => $days, 'hours' => $hours , 'minutes' => $minutesafterhour, 'totalMinutes' => $totalMinutesLeft];
                }
            }
            $todo['timeleft'] = $timeLeft;
            $todos[] = $todo;
        }
        $paginationLinks = $todosWithPage['links'];
        $numberOfPage = $todosWithPage['last_page'];
        $data = Http::withToken($token)->get('http://localhost:8008/api/serve/createData')->json();
        return view('index', compact('todos', 'paginationLinks','numberOfPage', 'todosWithPage', 'data', 'is_loggedIn', 'user'));
    }

    public function search(Request $request){
        $token = session('token');
        $user = session('user');
        if($token == null){
            return 'token is null';
        }
        if($user == null){
            return 'user is null';
        }
        $is_loggedIn = true;
        // end

        //set search_box and selection section for testpagination to use
        $search_box = $request->search_box;
        session(['search_box' => $search_box ]);
        $selection = $request->selection;
        session(['selection' => $selection ]);
        //

        $data = $request->all();
        unset($data['_token']);
        $todosWithPage = Http::withToken($token)->get('http://localhost:8008/api/serve/search', $data)->json();
        $todos = null;
        $todoswithOutTimeLeft = $todosWithPage['data'];

        //dealing with time
        foreach($todoswithOutTimeLeft as $todo){
            $startDate = Carbon::now();
            $endDate = Carbon::parse($todo['deadline']);
            if($startDate->gt($endDate)){
                $timeLeft = [ 'days' => 0, 'hours' => 0, 'minutes' => 0, 'totalMinutes' => 0 ];
            }
            else{
                $totalMinutesLeft = $startDate->diffInMinutes($endDate);
                if($totalMinutesLeft <= 0){
                    $timeLeft = [ 'days' => 0, 'hours' => 0, 'totalMinutes' => 0, 'minutes' => 0];
                }
                elseif($totalMinutesLeft < 60){
                    $timeLeft = [ 'days' => 0, 'hours' => 0, 'minutes' => $totalMinutesLeft, 'totalMinutes' => $totalMinutesLeft];
                }
                elseif($totalMinutesLeft < 1440){
                    $timeLeft = [ 'days' => 0, 'hours' => floor($totalMinutesLeft/60), 'minutes' => fmod($totalMinutesLeft, 60),'totalMinutes' => $totalMinutesLeft];
                }
                else{
                    $days = floor($totalMinutesLeft/1440);//1505/1440 = 1
                    $minutesafterday = $totalMinutesLeft - $days*1440;//1505 - 1*1440 = 65
                    $hours = floor($minutesafterday/60);// 65/60 = 1
                    $minutesafterhour = $minutesafterday - $hours*60; //65 - 1*60 = 5
                    $timeLeft = [ 'days' => $days, 'hours' => $hours , 'minutes' => $minutesafterhour, 'totalMinutes' => $totalMinutesLeft];
                }
            }
            $todo['timeleft'] = $timeLeft;
            $todos[] = $todo;
        }
        //

        //use for pagination
        $paginationLinks = $todosWithPage['links'];
        $numberOfPage = $todosWithPage['last_page'];
        //


        $data = Http::withToken($token)->get('http://localhost:8008/api/serve/createData')->json();
        return view('index', compact('todos', 'paginationLinks','numberOfPage', 'todosWithPage', 'data', 'is_loggedIn', 'user'));
    }
}
