<?php

namespace App\Http\Controllers\Admin;

// visto che il controller non si trova nella solita cartella, devo improtare il controller di base
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        // estrae in automatico solo gli utenti che hanno la colonna deleted_at = null
        $users = User::with('roles')
                    ->filterByStatus($request->query('status'))
                    ->orderBy('surname','asc') // ordino in ordine alfabetico, partendo dal cognome
                    ->orderBy('name', 'asc')
                    ->paginate(10)
                    ->withQueryString(); // Mantiene i parametri URL (es. ?status=trashed) navigando tra le pagine della paginazione (altrimenti perdi il filtraggio)

        
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

    public function destroy(User $user)
    {
        // Grazie al a SoftDeletes, questo NON cancellerà il record,
        // ma imposterà semplicemente il campo deleted_at con la data e ora attuali. 
        $user->delete();

        return redirect()->route('admin.users-management.index');
    }

    public function forceDestroy(User $user)
    {
        // 1) Sgangia le relazioni Molti-a-Molti per non lasciare record orfani
        $user->articles()->detach();
        $user->projects()->detach();
        $user->projects_created()->detach();
        $user->events_receives()->detach();
        $user->courses()->detach();

        // 2) Forza l'eliminazione definitiva
        $user->forceDelete();

        // 3) Ritorna alal pagina precedente
        return redirect()->route('admin.users-management.index');
    }
    
    public function restore(User $user)
    {
        dd("TODO");
    }
}
