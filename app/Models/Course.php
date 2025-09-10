<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'seat_limit'
    ];

    // Relations
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Total seats remaining (all sections sum)
    public function seatsRemaining()
    {
        return $this->sections->sum(function ($section) {
            return $section->seatsRemaining();
        });
    }
}
