<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Usuario;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function usersLogged()
    {
        $users = Usuario::all();
        return view('userslogged', compact('users'));
    }

    public function testeo(Request $request){
        $a = ((int)$request->number_one / (int)$request->number_two);
        dd($a);
        return redirect()->back();
    }

}
