<?php
namespace Erwinnerwin\LaravelApiGenerator\ApiGenerator;

use App\ApiGenerator\GenerateApiInterface;

class GenerateApiRoute implements GenerateApiInterface
{
    private $nameSpace;

    public function __construct(String $nameSpace)
    {
        $this->nameSpace = $nameSpace;
    }

    public function generate(): string
    {
        $lowerCaseNameSpace = strtolower($this->nameSpace);
        $index = "\t" . "Route::get('/', ['as' => '{$lowerCaseNameSpace}.index', 'uses' => 'App\Http\Controllers\\{$this->nameSpace}Controller@index']);" . PHP_EOL;
        $show = "\t" . "Route::get('/{id}', ['as' => '{$lowerCaseNameSpace}.show', 'uses' => 'App\Http\Controllers\\{$this->nameSpace}Controller@show']);" . PHP_EOL;
        $store = "\t" . "Route::post('/', ['as' => '{$lowerCaseNameSpace}.store', 'uses' => 'App\Http\Controllers\\{$this->nameSpace}Controller@store']);" . PHP_EOL;
        $delete = "\t" . "Route::delete('/{id}', ['as' => '{$lowerCaseNameSpace}.delete', 'uses' => 'App\Http\Controllers\\{$this->nameSpace}Controller@destroy']);" . PHP_EOL;
        $update = "\t" . "Route::put('/{id}', ['as' => '{$lowerCaseNameSpace}.update', 'uses' => 'App\Http\Controllers\\{$this->nameSpace}Controller@update']);" . PHP_EOL;
        
        //Route format
        $route = PHP_EOL . "Route::group(['prefix' => '{$lowerCaseNameSpace}'] ,function () {" . PHP_EOL .
            $index .
            $show .
            $store .
            $delete . 
            $update .
        "});";
        return $route;
    }
}