<?php
namespace Erwinnerwin\LaravelApiGenerator\ApiGenerator;

use ApiGenerator\GenerateApiInterface;

class GenerateModel implements GenerateApiInterface
{
    private $nameSpace;
    private $relationships;

    public function __construct(String $nameSpace, Array $relationships)
    {
        $this->nameSpace = $nameSpace;
        $this->relationships = $relationships;
    }

    public function generate(): string
    {
        $defaultImports = $this->getImports();

        $relationshipMethods = $this->getRelationshipMethods();
        
        $modelImports = $this->getModelImports();

        /** Main file */
        $class = $defaultImports . PHP_EOL .
        $modelImports . PHP_EOL . 
        "class {$this->nameSpace} extends Model" . PHP_EOL .
        "{"  . PHP_EOL .
            "\tuse HasFactory;" . PHP_EOL . PHP_EOL .
            $relationshipMethods . PHP_EOL .
        "}";
        
        return $class;
    }

    private function getImports(): string
    {
        $imports = "<?php" . PHP_EOL . PHP_EOL .
        "namespace App\Models;" . PHP_EOL . PHP_EOL .
        "use Illuminate\Database\Eloquent\Factories\HasFactory;" . PHP_EOL . 
        "use Illuminate\Database\Eloquent\Model;" . PHP_EOL;

        return $imports;
    }

    private function getRelationshipMethods(): string
    {
        $relationshipMethod = '';
        if($this->relationships){
            foreach($this->relationships as $value){
                if($value['relationship']){
                    $relationshipMethod .= $this->getCardinality($value['model'], $value['relationship']);
                }
            }
       }

       return $relationshipMethod;
    }

    private function getModelImports(): string
    {
        $models = '';
        if($this->relationships){
            foreach($this->relationships as $value){
                if($value['model']){
                    $model = $value['model'];
                    $models .= "use App\Models\\$model;"  . PHP_EOL;
                }
            }
        }

        return $models;
    }

    private function getCardinality(String $model, String $cardinality): string
    {
        $lowerCaseModel = strtolower($model);
        $oneToMany = 
        "\t" . "public function $lowerCaseModel()" . PHP_EOL .
        "\t{" . PHP_EOL .
        "\t\t" . "return \$this->$cardinality($model::class);" . PHP_EOL .
        "\t}" . PHP_EOL . PHP_EOL;
        
        return $oneToMany;
    }
}