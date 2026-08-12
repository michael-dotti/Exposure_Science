<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectStatus extends Model
{
	use HasFactory;

	protected $guarded = [];
	
	// un'area di ricerca può essere associata a più project
	public function projects(): HasMany
	{
		return $this->HasMany(Project::class);
	}
}
