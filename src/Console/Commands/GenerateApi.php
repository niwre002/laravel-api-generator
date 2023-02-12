<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ApiGenerator\GenerateFile;

class GenerateApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:api {api_name} {--relationship1=}{model1?} {--relationship2=}{model2?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API resource';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /** TODO: CLEANUP CODE AND REFACTOR */
        $apiName = $this->argument('api_name');
        $relationships = $this->handleRelationship();
        exec(sprintf('sudo php artisan make:model %s', $apiName));
        $migration = "create_". strtolower($apiName) . "_table";
        $generateApi = new GenerateFile($apiName, $relationships);
        $generateApi->createFile();
        $this->info($apiName . "Controller has been created");
        $this->info($apiName . "API routes resources has been created");
        $this->info($apiName . "View blade index has been created");
        $this->info($apiName . " Model has been created");
        exec(sprintf('sudo php artisan make:migration %s', $migration));
        $this->info($migration . " migration has been created");
        exec('sudo php artisan route:clear');
        $this->info('Route cache has been cleared');
        return Command::SUCCESS;
    }

    private function handleRelationship(): array
    {
        $relationships = [];

        if($this->option('relationship1') && $this->argument('model1')){
            $relationships[] = ['relationship' => $this->option('relationship1') , 'model' => $this->argument('model1')];
            if($this->option('relationship2') && $this->argument('model2')){
                $relationships[] = ['relationship' => $this->option('relationship2') , 'model' => $this->argument('model2')];
            }
        }

        return $relationships;
    }
}
