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
        $users = User::with('roles')
                    ->orderBy('surname','asc') // ordino in ordine alfabetico, partendo dal cognome
                    ->orderBy('name', 'asc')
                    ->paginate(10);
        return view('admin.users-management.index',compact('users'));
    }

    public function show()
    {
         dd("TODO");
    }

    public function create()
    {
         dd("TODO");
    }

    public function store()
    {
         dd("TODO");
        // 1) validazione
        // 2) intervention Image (se c'è foto profilo)
        // 3) caricare la foto profilo nello storage
        // 4) creare nuovo User
        // 5) redirect
    }
    
   /*  public function edit()
    {
        
    } */

    public function update()
    {
        // usato per cambiare i permessi di uno user dalla pagina admin.users-management.index
        dd("TODO");
    }

    public function destroy()
    {
        dd("TODO");
    }
    
}
