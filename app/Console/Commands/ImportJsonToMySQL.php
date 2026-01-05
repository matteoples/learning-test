<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportJsonToMySQL extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:import_json_mysql {path : Percorso della cartella JSON}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa dati dai backup JSON in un database MySQL';

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

        $this->info("Disabilito vincoli FK temporaneamente...");
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($jsonFiles as $file) {
            $table = $file->getBasename('.json');
            $this->info("Import tabella: {$table}...");

            $data = json_decode(File::get($file), true);

            if (empty($data)) {
                $this->warn("Nessun dato da importare per {$table}");
                continue;
            }

            // Svuota la tabella
            DB::table($table)->truncate();

            // Inserisci i dati
            DB::table($table)->insert($data);

            $this->info("Tabella {$table} importata con " . count($data) . " record.");
        }

        $this->info("Riattivo vincoli FK...");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info("Importazione completata!");
        return 0;
    }
}
