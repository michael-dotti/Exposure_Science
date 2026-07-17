<?php

namespace App\Http\Controllers\Admin;

// visto che il controller non si trova nella solita cartella, devo improtare il controller di base
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;

class UserManagementController extends Controller
{
    public function index()
    {
        dd("TODO");
    }

    public function show()
    {
        
    }

    public function create()
    {
        
    }

    public function store(){
        // 1) validazione
        // 2) intervention Image (se c'è foto profilo)
        // 3) caricare la foto profilo nello storage
        // 4) creare nuovo User
        // 5) redirect
    }
    
    public function edit()
    {
        
    }
    public function update()
    {
        
    }

    public function destroy()
    {
        
    }
    
}
