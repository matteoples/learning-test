<?php

namespace App\Models;

use Carbon\Carbon;
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

    protected $casts = [
        'data_nascita' => 'date',
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
    public function payments() {
        return $this->hasMany(Payment::class);
    } 

    public function getDataDiNascitaFormatted() {
        return $this->data_nascita ? $this->data_nascita->format('d/m/Y') : null;
    }

    public function getNomeCompleto() {
        if ($this->nome || $this->cognome) {
            return trim($this->nome . ' ' . $this->cognome);
        }
        return null;
    }

    public function getIniziali()
    {
        $iniziali = '';

        if ($this->nome) {
            $iniziali .= strtoupper(substr($this->nome, 0, 1));
        }

        if ($this->cognome) {
            $iniziali .= strtoupper(substr($this->cognome, 0, 1));
        }

        return $iniziali ?: null;
    }


}
