<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'nome',
        'cognome',
        'data_nascita',
        'telefono',
        'email',
        'indirizzo',
        'scuola',
        'classe',
        'note'
    ];

    // Relazione con tutor
    public function tutor() {
        return $this->belongsTo(User::class, 'user_id');
    }


    // Relazione con lezioni
    public function lessons() {
        return $this->hasMany(Lesson::class)->orderBy('giorno', 'desc')->orderBy('ora_inizio', 'desc');;
    } 

    // Relazione con pagamenti
    /* public function payments() {
        return $this->hasMany(Payment::class);
    } */
}
