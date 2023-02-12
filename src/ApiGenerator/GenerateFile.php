<?php

namespace Erwinnerwin\LaravelApiGenerator\ApiGenerator;

use ApiGenerator\GenerateController;
use ApiGenerator\GenerateModel;
use ApiGenerator\GenerateBladeView;
use ApiGenerator\GenerateApiRoute;
use File;

class GenerateFile
{
    private const CONTROLLER_FILE = 'Controller.php';
    private const PHP_EXT = '.php';
    private const API_FILE ='api.php';
    private const APP_CONTROLLER_PATH = 'app/Http/Controllers/';
    private const APP_MODEL_PATH = 'app/Models/';
    private const ROUTES = 'routes/';
    private const INDEX_BLADE = 'index.blade.php';
    private const PAGE = 'Index';
    private $apiName;
    private $lowerCaseApiName;
    private $relationships;

    public function __construct(String $apiName, Array $relationships)
    {
        $this->apiName = $apiName;
        $this->lowerCaseApiName = strtolower($apiName);
        $this->relationships = $relationships;
    }

    public function createFile(): void
    {
        $this->generateController();

        $this->generateModel();
        
        $this->generateBladeView();

        $this->generateApiResources();
    }

    private function generateController(): void
    {
        $path = base_path(self::APP_CONTROLLER_PATH);
        $data = (new GenerateController($this->apiName))->generate();
        $file = $this->apiName . self::CONTROLLER_FILE;
        $this->validateDirectory($path);
        File::put($path . $file, $data);
    }

    private function generateBladeView(): void
    {
        $bladePath = base_path("resources/views/$this->lowerCaseApiName/");
        $bladeFile = self::INDEX_BLADE;
        $bladeData = (new GenerateBladeView(self::PAGE))->generate();
        $this->validateDirectory($bladePath);
        File::put($bladePath.$bladeFile,$bladeData);
    }

    private function generateApiResources(): void
    {
        $apiPath = base_path(self::ROUTES);
        $apiData = (new GenerateApiRoute($this->apiName))->generate();
        $this->validateDirectory($apiPath);
        File::append($apiPath . self::API_FILE, $apiData);
    }

    private function generateModel(): void
    {
        $path = base_path(self::APP_MODEL_PATH);
        $data = (new GenerateModel($this->apiName, $this->relationships))->generate();
        $file = $this->apiName . self::PHP_EXT;
        $this->validateDirectory($path);
        File::put($path . $file, $data);
    }

    private function validateDirectory(String $path): void
    {
        if(!is_dir($path)){
            mkdir($path,0777,true);  
        }
    }
}