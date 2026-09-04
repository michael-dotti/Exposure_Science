<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ResearchArea;
use App\Models\User;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Mostra l'elenco pubblico delle pubblicazioni.
     */
    public function index(Request $request)
    {
        $userId = $request->integer('userId');
        $areaId = $request->integer('areaId');

        /*
         * Dati utilizzati nelle tendine dei filtri.
         */
        $users = User::query()
            ->select('id', 'name', 'surname')
            ->orderBy('surname')
            ->orderBy('name')
            ->get();

        $areas = ResearchArea::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        /*
         * Articoli con relazioni precaricate.
         *
         * withQueryString() mantiene i filtri anche quando
         * si cambia pagina tramite la paginazione.
         */
        $articles = Article::query()
            ->with([
                'users:id,name,surname',
                'researchAreas:id,name',
            ])
            ->filterByArea($areaId)
            ->filterByUser($userId)
            ->latest('articles.created_at')
            ->paginate(8)
            ->withQueryString();

        /*
         * Etichette dei filtri attualmente selezionati.
         */
        $currentFilters = [];

        if ($userId) {
            $selectedUser = $users->firstWhere('id', $userId);

            if ($selectedUser) {
                $currentFilters[] = [
                    'label' => 'Autore',
                    'value' => trim(
                        $selectedUser->name . ' ' . $selectedUser->surname
                    ),
                ];
            }
        }

        if ($areaId) {
            $selectedArea = $areas->firstWhere('id', $areaId);

            if ($selectedArea) {
                $currentFilters[] = [
                    'label' => 'Area di ricerca',
                    'value' => $selectedArea->name,
                ];
            }
        }

        return view('public.articles.index', compact(
            'articles',
            'users',
            'areas',
            'currentFilters'
        ));
    }

    /**
     * Mostra una singola pubblicazione.
     */
    public function show(Article $article)
    {
        /*
         * Evita query aggiuntive nella pagina Blade.
         *
         * Se "document" è una relazione Eloquent, viene
         * precaricata insieme ad autori e aree.
         */
        $article->load([
            'users:id,name,surname',
            'researchAreas:id,name',
            'document',
        ]);

        return view('public.articles.show', compact('article'));
    }
}