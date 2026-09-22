<?php

namespace App\Console\Commands;

use App\Models\ReportErrorLogModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database to S3';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // try {
        //     Log::info('DB Backup: Starting direct S3 backup process');
    
        //     // Create backup filename
        //     $filename = "backup-" . Carbon::now()->format('Y-m-d_H:i:s') . ".sql";
            
        //     // Get database credentials from env
        //     $dbUser = env('DB_USERNAME');
        //     $dbPass = env('DB_PASSWORD');
        //     $dbName = env('DB_DATABASE');
    
        //     // Create a temporary resource
        //     $tempStream = fopen('php://temp', 'r+');
            
        //     // Execute mysqldump and write to the temp stream
        //     $command = "mysqldump --user={$dbUser} --password={$dbPass} {$dbName}";
        //     exec($command, $output);
            
        //     // Write the output to temp stream
        //     fwrite($tempStream, implode("\n", $output));
            
        //     // Rewind the stream
        //     rewind($tempStream);
            
        //     // Upload directly to S3
        //     try {
        //         Storage::disk('s3')->put("backup/{$filename}", $tempStream);
        //         Log::info('DB Backup: Successfully uploaded to S3', ['filename' => $filename]);
                
        //         ReportErrorLogModel::create([
        //             'type' => 'DB Backup',
        //             'subtype' => 'Success',
        //             'description' => "Backup uploaded to S3: backup/{$filename}"
        //         ]);
        //     } catch (\Exception $e) {
        //         Log::error('DB Backup: S3 upload failed', ['error' => $e->getMessage()]);
        //         throw $e;
        //     } finally {
        //         // Clean up
        //         fclose($tempStream);
        //     }
    
        // } catch (\Exception $e) {
        //     Log::error('DB Backup: Process failed', ['error' => $e->getMessage()]);
            
        //     ReportErrorLogModel::create([
        //         'type' => 'DB Backup',
        //         'subtype' => 'Error',
        //         'description' => $e->getMessage()
        //     ]);
        // }
        
            
            $databaseName = env('DB_DATABASE');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $host = env('DB_HOST');
            $port = env('DB_PORT', '3306');

            // Log environment variables to debug
            Log::debug('Database Username: ' . $username);
            Log::debug('Database Password: ' . $password);
            Log::debug('Database Host: ' . $host);

            $date = now()->format('Y-m-d_H-i-s');
            $backupFile = "{$databaseName}_{$date}.sql"; // No need for the 'backup/' directory as we're using local disk

            // Ensure the backup directory exists in the local disk
            $backupDir = 'backup';
            if (!Storage::disk('local')->exists($backupDir)) {
                Storage::disk('local')->makeDirectory($backupDir);
            }

            // Specify the full path to mysqldump if it's not in the system's PATH
            $mysqldumpPath = '/usr/bin/mysqldump'; // Update this to the correct path if necessary

            // Build the command
            $backupPath = storage_path("app/{$backupDir}/{$backupFile}"); // Using Laravel's local disk path
            $command = "{$mysqldumpPath} --user={$username} --password={$password} --host={$host} --port={$port} {$databaseName} > {$backupPath}";

            // Log the command for debugging purposes
            Log::debug('Backup command: ' . $command);

            // Execute the command
            exec($command, $output, $return);

            // Check if the backup was successful
            if ($return === 0) {
                $this->info('Backup successfully created: ' . $backupFile);
            } else {
                $this->error('Backup failed.');
            }
    }
}
