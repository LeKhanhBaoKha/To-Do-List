<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    use HasFactory;
    public function project(): BelongsTo{
        return $this->belongsTo(Project::class);
    }

    public function User():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
