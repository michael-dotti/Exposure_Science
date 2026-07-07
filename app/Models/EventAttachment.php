<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAttachment extends Model
{
    protected $fillable = ['file_name','file_path'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
