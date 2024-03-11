<?php

namespace App\Http\Controllers;

use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    public function index(){
        $token = session('token');
        if($token == null){
            return 'token is null';
        }

        $todos = Http::withToken($token)->get('http://localhost:8008/api/serve/index')->json();
        $data = Http::withToken($token)->get('http://localhost:8008/api/serve/createData')->json();
        // return $todos;
        return view('index', compact('todos', 'data') );
    }

    public function details(Request $request){
        $todo = Http::get(`http://localhost:8008/api/serve/{$request->id}`)->json();
        return $todo;
    }

    public function destroy($id){
        $response = Http::post('http://localhost:8008/api/serve/delete',[
            'id' => $id,
            '_method' => 'delete'
        ]);
        return redirect('api/index');
    }

    public function create(){
        $data = Http::get('http://localhost:8008/api/serve/createData')->json();
        // return $data['projects'][0];
        return view('create', compact('data'));
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
        $data = request()->all();
        Http::post('http://localhost:8008/api/serve/store',[
            'name' => $data['name'],
            'description' => $data['description'],
            'project_id' => $data['project_id'],
            'user_id' => $data['user_id']
        ]);
        return redirect(('api/index'));
    }

    public function update(){
        try{
            $this->validate(request(),[
                'id' => ['required'],
            ]);
        }catch(ValidationException $e){

        }
        $data=request()->all();
        $data['_method'] = 'patch';
        Http::patch('http://localhost:8008/api/serve/update',$data);
        return redirect('api/index');
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
        Http::post('http://localhost:8008/api/serve/register', $data);
        return $data;
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
            $token = $response->json()['authorisation']['token'];
            session(['token' => $token ]);
            return redirect('api/index');
        }
        else{
            return redirect()->back()->withErrors(['login' => 'Login failed. Please try again.']);
        }
    }
}
