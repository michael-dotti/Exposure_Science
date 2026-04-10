<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function update(User $user){
        // validate 
        // upload the image and save the path
        // update user
        // redirect
        dd(request());
    }
}
