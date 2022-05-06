<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\ImportService;

class ImportManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importing the JSON content to the database';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $file = $this->argument('file');
        $data = json_decode(file_get_contents($file), false);
        
        $importService = new ImportService();

        ini_set('max_execution_time', 120000);

        DB::transaction(function() use ($data, $importService) {
            $importService->execute($data);
        });
        
    }

    
}
