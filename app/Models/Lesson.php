<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'student_id', 
        'giorno', 
        'ora_inizio', 
        'ora_fine', 
        'luogo', 
        'argomento', 
        'subject_id', 
        'user_id',
        'google_event_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function durata()
    {
        if ($this->ora_inizio && $this->ora_fine) {
            $start = Carbon::parse($this->ora_inizio);
            $end = Carbon::parse($this->ora_fine);
            return $start->diffInMinutes($end) / 60; // ore con decimali
        }

        return 0;
    }

    public function getOraInizioFormatted() {
        return Carbon::parse($this->ora_inizio)->format('H:i');
    }

    public function getOraFineFormatted() {
        return Carbon::parse($this->ora_fine)->format('H:i');
    }

    public function getGiornoFormatted() {
        return Carbon::parse($this->giorno)->format('Y-m-d');
    }

    public function getTextGiornoFormatted() {
        return ucfirst(
        Carbon::parse($this->giorno)
            ->locale('it')
            ->isoFormat('ddd D MMMM \'YY')
    );
    }
}

