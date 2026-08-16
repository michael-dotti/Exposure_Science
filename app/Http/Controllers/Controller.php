<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Reindirizza indietro (mantenendo i filtri/query string) se la pagina precedente
     * corrisponde alla rotta passata (cosi da mantenere i filtri applicati alla pagina
     * index), altrimenti reindirizza alla rotta/URL indicato.
     *
     * @param string $route Nome della rotta (es. 'admin.users-management.index') o un URL completo
     * @param array $parameters Parametri opzionali da passare alla rotta (es: l'eventuale "id" da passare alla rotta)
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectBackOrTo(string $route, array $parameters = [])
    {
        // Se $route è un nome di rotta valido lo trasforma in URL, altrimenti usa la stringa ricevuta
        $targetUrl = \Illuminate\Support\Facades\Route::has($route) 
            ? route($route, $parameters) 
            : $route;

        // Estraiamo solo il path (senza i parametri ?status=...) di entrambe le URL
        $previousPath = parse_url(url()->previous(), PHP_URL_PATH);
        $targetPath   = parse_url($targetUrl, PHP_URL_PATH);

        // Se eravamo già in quella pagina, torniamo indietro mantenendo tutti i filtri
        if ($previousPath === $targetPath) {
            return redirect()->back();
        }

        // Altrimenti andiamo alla rotta pulita di destinazione
        return redirect()->to($targetUrl);
    }
}
