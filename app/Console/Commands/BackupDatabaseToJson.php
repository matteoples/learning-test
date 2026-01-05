<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class BackupDatabaseToJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup_to_json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esegue un backup del database PostgreSQL in JSON';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Inizio backup del database in JSON...');

        // Cartella principale per i backup
        $backupPath = storage_path('backups/json_backup_' . date('Y_m_d_H_i_s'));
        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        // Recupera tutte le tabelle pubbliche
        $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname='public'");

        foreach ($tables as $table) {
            $tableName = $table->tablename;
            $this->info("Backup tabella: {$tableName}...");

            // Recupera tutti i dati
            $data = DB::table($tableName)->get();

            // Scrive il JSON
            File::put("{$backupPath}/{$tableName}.json", $data->toJson(JSON_PRETTY_PRINT));

            $this->info("Tabella {$tableName} salvata con " . count($data) . " record.");
        }

        $this->info("Backup completato! Tutti i file JSON si trovano in: {$backupPath}");
    }
}
