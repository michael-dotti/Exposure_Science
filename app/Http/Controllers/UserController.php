<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use function Livewire\store;

class UserController extends Controller
{
    public function index(){
         $users = User::with('roles')
                    ->orderBy('surname','asc') // ordino in ordine alfabetico, partendo dal cognome
                    ->orderBy('name', 'asc')
                    ->get();
        return view('public.users.index', compact('users')); 
    }


    public function show(User $user){
        return view('public.users.show',['user'=> $user] );
    }

}
