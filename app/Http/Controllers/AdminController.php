<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class AdminController extends Controller
{
    public function login(Request $req)
    {
        if (!App::runningInConsole()) {
            $res = Admin::where(['email' => $req->post('email')])->first();
        }
        if ($res) {
            if (Hash::check($req->post('password'), $res->password)) {
                $req->session()->put('admin_login', true);
                $req->session()->put('admin_name', $res->name);
                return redirect('dashboard');
            } else {
                $req->session()->flash('error', 'Aww ! Enter Valid Password.');
                return redirect('/');
            }
        } else {
            $req->session()->flash('error', 'Aww ! Enter Valid Email.');
            return redirect('/');
        }
    }
}
