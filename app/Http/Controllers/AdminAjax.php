<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;

class AdminAjax extends Controller
{
    //

    public function handleLogin(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::guard('admin')->attempt($credentials)) {
            Session::flash('login_m', 'You successfully Login.');
            return redirect()->intended('/admin/dashboard');
        }
    
        throw ValidationException::withMessages(['error' => 'Invalid credentials']);
    }

    public function handleLogout(Request $request) {
        Auth::guard('admin')->logout();
        Session::flash('logout_message', 'You have been logged out successfully.');
        return redirect()->route('admin.login');
    }


    public function index(Request $request, $modelname) {

        $action = $request->action;

        if($action ==  'add') {
            $ModeName = ucfirst($modelname);
            $add = "\App\Http\Controllers\ModelController\\$ModeName";
            $add_instance = new $add();
            $adding = $add_instance->add($request);
            return response()->json($adding);
        } else if($action == 'list') {

            $ModeName = ucfirst($modelname);
            $class = "\App\Http\Controllers\ModelController\\$ModeName";
            $List = new $class();
            $data = $List->list($request);
            return response()->json($data);
        } else if($action == 'settingStatus') {

            $ModeName = ucfirst($modelname);
            $class = "\App\Http\Controllers\ModelController\\$ModeName";
            $List = new $class();
            $data = $List->toStatus($request);
            return response()->json($data);
        }  else if($action == 'edit') {

            $ModeName = ucfirst($modelname);
            $class = "\App\Http\Controllers\ModelController\\$ModeName";
            $instance = new $class();
            $data = $instance->edit($request);
            return response()->json($data);
        } else if($action == "getRow") {

            $ModeName = ucfirst($modelname);
            $class = "\App\Http\Controllers\ModelController\\$ModeName";
            $List = new $class();
            $data = $List->getRow($request);
            return response()->json($data);
        }
    }
}
