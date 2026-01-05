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
        'telefono',
        'tariffa_oraria',
        'email',
        'indirizzo',
        'scuola',
        'classe',
        'note'
    ];

    protected $casts =  [];

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

    public function getNomeCompleto() {
        if ($this->nome || $this->cognome) {
            return trim($this->nome . ' ' . $this->cognome);
        }
        return null;
    }

    public function getIniziali(){
        $iniziali = '';

        if ($this->nome) {
            $iniziali .= strtoupper(substr($this->nome, 0, 1));
        }

        if ($this->cognome) {
            $iniziali .= strtoupper(substr($this->cognome, 0, 1));
        }

        return $iniziali ?: null;
    }

    public function getTotalPayments() {
        return floor($this->payments()->sum('importo'));
    }

    public function getTotalLessons() {
        // somma delle ore in formato decimale
        $totalHours = $this->lessons->sum(function ($lesson) {
            $start = Carbon::parse($lesson->ora_inizio);
            $end = Carbon::parse($lesson->ora_fine);
            return $start->floatDiffInHours($end);
        });

        return $totalHours;
    }

    public function getTotalLessonsFormatted() {
        $totalHours =  $this->getTotalLessons();

        // parte intera delle ore
        $hours = floor($totalHours);

        // minuti ricavati dalla parte decimale
        $minutes = round(($totalHours - $hours) * 60);

        if ($minutes==0) {
            return "{$hours}h";
        }
        return "{$hours}h {$minutes}min";
    }

    public function saldo() {
        $totaleDebiti = $this->tariffa_oraria * $this->getTotalLessons();
        $totaleDebiti = ceil($totaleDebiti);
        $totaleCrediti = $this->getTotalPayments();

        //il metodo ritorna il saldo, positivo se siamo in credito, negativo se siamo in debito
        return $totaleCrediti - $totaleDebiti;

    }


    public function saldoOrario() {
        if ($this->tariffa_oraria == 0) { return 0; }
        $oreDecimali = abs($this->saldo()) / $this->tariffa_oraria;

        $oreIntere = floor($oreDecimali); // parte intera
        $frazione = $oreDecimali - $oreIntere; // parte decimale

        // arrotondamento frazione a 0, 0.25, 0.5, 0.75, 1
        if ($frazione < 0.125) {
            $frazione = 0;       // meno di 7,5 min → arrotonda giù
        } elseif ($frazione < 0.375) {
            $frazione = 0.25;    // 7,5 - 22,5 min → 15 min
        } elseif ($frazione < 0.625) {
            $frazione = 0.5;     // 22,5 - 37,5 min → 30 min
        } elseif ($frazione < 0.875) {
            $frazione = 0.75;    // 37,5 - 52,5 min → 45 min
        } else {
            $frazione = 1;       // >52,5 min → arrotonda all’ora successiva
        }

        return $oreIntere + $frazione;
    }


    public function saldoOrarioFormatted() {
        $saldo = $this->saldoOrario(); // ottieni ore decimali arrotondate

        $ore = floor($saldo);                  // parte intera → ore
        $minuti = ($saldo - $ore) * 60;       // parte decimale → minuti
        $minuti = round($minuti);             // arrotonda al minuto più vicino

        // Se i minuti sono zero, li ometti
        if ($minuti == 0) {
            return "{$ore}h";
        }

        return "{$ore}h {$minuti}min";
    }






    
    public function hasDebt()
    {
        return $this->getDebitHours() > 0;
    }

    public function getCreditHours() {
        
        $paidHours = $this->payments()->sum('numero_ore');
        $doneHours = $this->getTotalLessons();

        $credit = $paidHours - $doneHours;

        return $credit > 0 ? $credit : 0;
        
    }

    public function getDebitHours() {
        $paidHours = $this->payments()->sum('numero_ore');
        $doneHours = $this->getTotalLessons();

        $debit = $doneHours - $paidHours;

        return $debit > 0 ? $debit : 0;
    }
        


}
