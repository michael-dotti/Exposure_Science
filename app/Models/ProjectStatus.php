<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Article;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProjectStatus extends Model
{
	use HasFactory;

	protected $guarded = [];
	
	// un'area di ricerca può essere associata a più project
	public function projects(): BelongsToMany
	{
		return $this->belongsToMany(Project::class);
	}
}
