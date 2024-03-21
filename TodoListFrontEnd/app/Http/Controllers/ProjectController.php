<?php

namespace App\Http\Controllers;

use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProjectController extends Controller
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

        $projectsWithPage = Http::withToken($token)->get('http://localhost:8008/api/serve/projects')->json();
        $projects = $projectsWithPage['data'];
        $paginationLinks = $projectsWithPage['links'];
        $numberOfPage = $projectsWithPage['last_page'];
        $todosWithPage = $projectsWithPage;
        return view('project.index', compact('projects', 'paginationLinks', 'numberOfPage', 'is_loggedIn', 'user', 'todosWithPage'));
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
        $link = key($request->all()).'='.implode($request->all());
        //fetch the data for the page the user clicked
        $todosWithPage = Http::withToken($token)->get($link)->json();

        $projects = $todosWithPage['data'];
        $paginationLinks = $todosWithPage['links'];
        $numberOfPage = $todosWithPage['last_page'];
        return view('project.index', compact('projects', 'paginationLinks', 'numberOfPage', 'todosWithPage', 'is_loggedIn', 'user'));
    }

    public function store(Request $request){
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
        try{
            $this->validate(request(),[
                'name' => ['required']
            ]);
        }catch(ValidationException $e){
            return response()->json([
                'status' => 'error',
                'message' => 'please fill the name field',
            ]);
        }

        Http::withToken($token)->post('http://localhost:8008/api/serve/createProject', $request->all())->json();
        return redirect()->back();
    }

    public function destroy(Request $request){
        // handling token and user authentication
        $token = session('token');
        if($token == null){
            return 'token is null';
        }
        try{
            $this->validate(request(),[
                'id' => ['required']
            ]);
        }catch(ValidationException $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Can not find the project you want to delete',
            ]);
        }
        Http::withToken($token)->post('http://localhost:8008/api/serve/deleteProject', $request->all())->json();
        return redirect()->back();
    }
}
