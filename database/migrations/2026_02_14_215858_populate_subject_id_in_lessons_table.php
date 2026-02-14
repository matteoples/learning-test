<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $lessons = DB::table('lessons')->get();

        foreach ($lessons as $lesson) {
            if (!$lesson->materia) continue;

            // Pulizia della materia: trim, minuscolo e rimuove accenti
            $cleanName = strtolower(trim($lesson->materia));
            $cleanName = strtr($cleanName, 'àèéìòù', 'aeeiou'); // opzionale per accenti

            // Controlla se esiste già la materia nel DB
            $subject = DB::table('subjects')
                ->whereRaw('LOWER(nome) = ?', [$cleanName])
                ->first();

            if (!$subject) {
                // Inserisci nuova materia
                $subjectId = DB::table('subjects')->insertGetId([
                    'nome' => ucfirst($cleanName),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $subjectId = $subject->id;
            }

            // Aggiorna la lezione
            DB::table('lessons')->where('id', $lesson->id)->update([
                'subject_id' => $subjectId,
            ]);
        }
    }

    public function down(): void
    {
        // Annulla popolamento
        DB::table('lessons')->update(['subject_id' => null]);
    }
};
