<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        // Elenco materie principali
        $subjects = [
            'Matematica',
            'Fisica',
            'Chimica',
            'Biologia',
            'Informatica',
            'Sistemi e Reti',
            'TPSIT',
            'Telecomunicazioni',
            'Italiano',
            'Storia',
            'Geografia',
            'Inglese',
            'Francese',
            'Spagnolo',
            'Latino',
            'Greco',
            'Arte'
        ];

        foreach ($subjects as $nome) {
            Subject::firstOrCreate(['nome' => $nome]);
        }
    }
}
