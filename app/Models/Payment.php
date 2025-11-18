<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'student_id',
        'data',
        'modalita',
        'importo',
        'numero_ore',
        'note'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getTextGiornoFormatted() {
        return ucfirst(
        Carbon::parse($this->data)
            ->locale('it')
            ->isoFormat('ddd D MMMM \'YY')
    );
    }
}