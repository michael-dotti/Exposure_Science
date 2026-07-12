<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use function Livewire\store;

class UserController extends Controller
{
    public function index(){
         $users = User::all();
        return view('public.users.index', compact('users')); 
    }

    public function show(User $user){
         return view('public.users.show',['user'=> $user] );
    }

}
