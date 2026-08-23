<?php

namespace App\Enums;

enum ProjectStatusType: string
{
	case PLANNED = 'planned';
	case ACTIVE = 'active';
	case SUSPENDED = 'suspended';
	case COMPLETED = 'completed';

	// Questo metodo ti restituisce l'italiano pulito per la UI
	public function label(): string
	{
		return match($this) {
			self::PLANNED => 'Pianificato',
			self::ACTIVE => 'Attivo',
			self::SUSPENDED => 'Sospeso',
			self::COMPLETED => 'Completato',
		};
	}

	// Puoi aggiungere la descrizione direttamente qui
    public function description(): string
    {
        return match($this) {
            self::PLANNED => 'Il progetto è stato ideato ma non sono ancora iniziati i lavori.',
            self::ACTIVE => 'Il team sta attualmente lavorando al progetto.',
            self::SUSPENDED => 'I lavori sono temporaneamente in pausa.',
            self::COMPLETED => 'Tutti gli obiettivi del progetto sono stati raggiunti.',
        };
    }
}
