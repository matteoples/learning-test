<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class RestoreDatabaseFromJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:restore_from_json {path : Percorso della cartella JSON}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ripristina il database dai backup JSON';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = $this->argument('path');

        if (!File::exists($path)) {
            $this->error("La cartella {$path} non esiste!");
            return 1;
        }

        $jsonFiles = File::files($path);

        if (empty($jsonFiles)) {
            $this->warn("Nessun file JSON trovato in {$path}");
            return 0;
        }

        // Disabilita temporaneamente i vincoli FK per evitare problemi
        DB::statement('SET session_replication_role = replica;');

        foreach ($jsonFiles as $file) {
            $table = $file->getBasename('.json');
            $this->info("Ripristino tabella: {$table}...");

            $data = json_decode(File::get($file), true);

            if (empty($data)) {
                $this->warn("Nessun dato da ripristinare per {$table}");
                continue;
            }

            // Svuota la tabella
            DB::table($table)->truncate();

            // Inserisci i dati
            DB::table($table)->insert($data);

            $this->info("Tabella {$table} ripristinata con " . count($data) . " record.");
        }

        // Riattiva i vincoli FK
        DB::statement('SET session_replication_role = DEFAULT;');

        $this->info("Ripristino completato!");
        return 0;
    }
}
