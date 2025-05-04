<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;

class GenerateDailyLogReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        logger()->info('Début du job GenerateDailyLogReport');
        try {
            // Chemin du fichier de log du jour (mode daily)
            $logPath = storage_path('logs/laravel-' . now()->format('Y-m-d') . '.log');
            logger()->info('Chemin du log: ' . $logPath);
            if (!file_exists($logPath)) {
                // Si le fichier n'existe pas (pas de log ce jour), on arrête
                logger()->warning('Fichier de log non trouvé: ' . $logPath);
                return;
            }

            // Lecture du fichier ligne par ligne
            $lines = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            // Préparation du CSV
            $csv = Writer::createFromString('');
            $csv->insertOne(['Date', 'Niveau', 'Message']);

            foreach ($lines as $line) {
                // Exemple de ligne : [2024-05-04 13:45:12] local.INFO: User logged in {"id":1}
                if (preg_match('/\[(.*?)] (\w+)\.(\w+): (.*)/', $line, $matches)) {
                    $date = $matches[1];
                    $env = $matches[2];
                    $level = strtoupper($matches[3]);
                    $message = $matches[4];
                    $csv->insertOne([$date, $level, $message]);
                }
            }

            // Stockage du fichier CSV
            $filename = 'logs/report-' . now()->format('Y-m-d') . '.csv';
            Storage::disk('local')->put($filename, $csv->toString());
            logger()->info('Rapport généré avec succès: ' . $filename);
        } catch (\Exception $e) {
            logger()->error('Erreur génération rapport logs : ' . $e->getMessage());
            throw $e;
        }
    }
}
