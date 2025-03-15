<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Task;
use App\Observers\TaskObserver;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use PDO;
use PDOException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Task::observe(TaskObserver::class);


        $databaseName = env('DB_DATABASE');
        $config = config('database.connections.mysql');

        try {
            // Try connecting to the database
            DB::connection()->getPdo();
        } catch (PDOException $e) {
            // Database might not exist, so create it
            Log::warning("Database [$databaseName] does not exist. Attempting to create it.");

            // Build a DSN without specifying the database
            $dsn = "mysql:host={$config['host']};port={$config['port']}";
            try {
                $pdo = new PDO($dsn, $config['username'], $config['password']);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // Create the database using the name from the .env file
                $pdo->exec("CREATE DATABASE IF NOT EXISTS `$databaseName` CHARACTER SET {$config['charset']} COLLATE {$config['collation']}");
                Log::info("Database [$databaseName] created successfully.");
            } catch (PDOException $ex) {
                Log::error("Could not create database [$databaseName]: " . $ex->getMessage());
                return;
            }
        }

        // Check if the migrations table exists. If not, run the migrations.
        if (!Schema::hasTable('migrations')) {
            try {
                Artisan::call('migrate', ['--force' => true]);
                Log::info("Migrations run successfully.");
            } catch (\Exception $e) {
                Log::error("Error running migrations: " . $e->getMessage());
            }
        }
    }
}
