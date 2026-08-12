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
}
