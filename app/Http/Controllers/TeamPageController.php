<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use function Livewire\store;

class TeamPageController extends Controller
{
    public function index(){
         $users = User::all();
        return view('teamPage.index', compact('users')); 
    }

    public function show(User $user){
         return view('teamPage.show',['user'=> $user] );
    }

}
