<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait EventPaginationTrait
{
    protected function calculateCustomPagination(Collection $allIds, int $currentEventId): array
    {
        // 1) Calcolo i dati per la paginazione
        $totalEvents = $allIds->count(); // conto quandi eventi ci sono
        $currentIndex = $allIds->search($currentEventId); // restituisco l'index dell'evento attuale
        $currentPage = $currentIndex !== false ? $currentIndex + 1 : 1; // calcolo la prossima pagina che è $currentIndex +1 se la posizione è !== 0 (sono gli eventi sono dentro ad un array e questo inizia a contare da 0, ma dobbiamo visualizzare la prima apgina come 1 non 0), altrimenti 1

        // 2) Trovo gli id precedente e successivo
        $prevEventId = $currentIndex > 0 ? $allIds[$currentIndex -1] : null;
        $nextEventId = $currentIndex !== false && $currentIndex < ($totalEvents -1) ? $allIds[$currentIndex +1] : null;

        // 3) ritorno un array contenente i dati che mi servono per effettuale la paginazioen show per gli eventi
        return [
            'totalEvents' => $totalEvents,
            'currentPage' => $currentPage,
            'prevEventId' => $prevEventId,
            'nextEventId' => $nextEventId,
        ];
    }
}
