<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    protected $fillable = [
        'name',
        'description',
        'state',
        'project_id',
        'user_id',
        'deadline',
        'timeLeft',
    ];
    use HasFactory;
    public function project(): BelongsTo{
        return $this->belongsTo(Project::class);
    }

    public function User():BelongsTo{
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->calculateTimeLeft();
        });

        static::updating(function ($model) {
            $model->calculateTimeLeft();
        });
    }

    protected function calculateTimeLeft()
    {
        $deadline = Carbon::parse($this->deadline); // Assuming 'deadline' is a column in your table
        $now = Carbon::now();
        if($now->gt($deadline)){
            $timeLeft = 0;
        }
        else{
            $timeLeft = $now->diffInMinutes($deadline);
        }
        $this->timeLeft = $timeLeft;
    }
}
