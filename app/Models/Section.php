<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'name', 'max_seats'
    ];

    // Relations
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Seats remaining in this section
    public function seatsRemaining()
    {
        $enrolled = $this->enrollments()->count();
        return $this->max_seats - $enrolled;
    }
}
