<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory,SoftDeletes;
    public function Todos(): HasMany{
        return $this->hasMany(Todo::class);
    }

    public function User(): HasMany{
        return $this->hasMany(User::class);
    }
}
