<?php
namespace Erwinnerwin\LaravelApiGenerator\ApiGenerator;

use App\ApiGenerator\GenerateApiInterface;

class GenerateController implements GenerateApiInterface
{
    private $nameSpace;

    public function __construct(String $nameSpace)
    {
        $this->nameSpace = $nameSpace;
    }

    public function generate(): string
    {
        /** Namespace and default imports */
        $defaultImports = $this->getImports();

        /** Model imports */
        $models = $this->getModelImports();

        /** Class Constructor format */
        $constructor = $this->getConstructor();

        /** Index method */
        $index = $this->getIndexMethod();

        /** Show Method */
        $show = $this->getShowMethod();
        
        /** Update Method */
        $update = $this->getUpdateMethod();

        /** Store Method */
        $store = $this->getStoreMethod();

        /** Destroy Method */
        $destroy =  $this->getDestroyMethod();

        /** Main file */
        $class = $defaultImports . $models .
        "class {$this->nameSpace}Controller extends Controller" . PHP_EOL .
        "{"  . PHP_EOL .
            "{$constructor}" .
            "{$index}" . 
            "{$show}" . 
            "{$update}" . 
            "{$store}" .
            "{$destroy}" .
        "}";
        
        return $class;
    }

    private function getImports(): string
    {
        $imports = "<?php" . PHP_EOL .
        "namespace App\Http\Controllers;" . PHP_EOL .
        "use Illuminate\Http\Request;" . PHP_EOL . 
        "use Illuminate\Http\JsonResponse;" . PHP_EOL .
        "use Response;" . PHP_EOL;

        return $imports;
    }

    private function getModelImports(): string
    {
          $models = "use App\Models\\$this->nameSpace;"  . PHP_EOL . PHP_EOL;

          return $models;
    }

    private function getConstructor(): string
    {
         $constructor = "\tpublic function __construct()" . PHP_EOL .
         "\t{" . PHP_EOL . PHP_EOL . "\t}" . PHP_EOL . PHP_EOL;
         return $constructor;
    }

    private function getIndexMethod(): string
    {
        $index = "\t" . "/**" . PHP_EOL .
        "\t" . "* $this->nameSpace get all." . PHP_EOL .
        "\t" . "*" . PHP_EOL .
        "\t" . "* @param  \Illuminate\Http\Request \$request (GET Method)" . PHP_EOL .
        "\t" . "* @return \Illuminate\Http\Response" . PHP_EOL .
        "\t" . "*/" . PHP_EOL . //END OF PARAMETER
        "\t" . 'public function index(Request $request): JsonResponse' . PHP_EOL .
        "\t{" . PHP_EOL .
        "\t\t" . "\$data = $this->nameSpace::orderBy('created_at', 'asc')->get();" . PHP_EOL .
        "\t\t" . "if(\$data){" . PHP_EOL .
        "\t\t\t" . "return Response::json(['data' => \$data, 'status' => 'success'], 200);" . PHP_EOL .
        "\t\t}" . PHP_EOL .
        "\t\t" . "return Response::json(['msg' => 'data not found', 'status' => 'error'], 404);" . PHP_EOL . 
        "\t}" . PHP_EOL . PHP_EOL;

        return $index;
    }

    private function getShowMethod(): string
    {
        $show = "\t" . "/**" . PHP_EOL .
        "\t" . "* Show search $this->nameSpace" . PHP_EOL .
        "\t" . "*" . PHP_EOL .
        "\t" . "* @param  \Illuminate\Http\Request \$request (GET Method)" . PHP_EOL .
        "\t" . "* @param  int  \$id" . PHP_EOL .
        "\t" . "* @return \Illuminate\Http\Response" . PHP_EOL .
        "\t" . "*/" . PHP_EOL . //END OF PARAMETER
        "\t" . 'public function show(Request $request, int $id): JsonResponse' . PHP_EOL .
        "\t{" . PHP_EOL .
        "\t\t" . "try{" . PHP_EOL .
        "\t\t\t" . "\$data = $this->nameSpace::findorFail(\$id);" . PHP_EOL .
        "\t\t\t" . "return Response::json(['data' => \$data, 'status' => 'success'], 200);" . PHP_EOL .
        "\t\t" . "}catch(\Exception \$e){" . PHP_EOL .
        "\t\t\t" . "return Response::json(['msg' => 'data not found', 'status' => 'error'], 404);" . PHP_EOL . 
        "\t\t" . "}" . PHP_EOL . 
        "\t}" . PHP_EOL . PHP_EOL;
        return $show;
    }

    private function getUpdateMethod(): string
    {
        $update = "\t" . "/**" . PHP_EOL .
        "\t" . "* Update $this->nameSpace" . PHP_EOL .
        "\t" . "*" . PHP_EOL .
        "\t" . "* @param  \Illuminate\Http\Request \$request (PUT Method)" . PHP_EOL .
        "\t" . "* @param  int  \$id" . PHP_EOL .
        "\t" . "* @return \Illuminate\Http\Response" . PHP_EOL .
        "\t" . "*/" . PHP_EOL . //END OF PARAMETER
        "\t" . 'public function update(Request $request, int $id): JsonResponse' . PHP_EOL .
        "\t{" . PHP_EOL .
        "\t\t" . "\$item = $this->nameSpace::findorFail" . '($id);' . PHP_EOL . "\t" . PHP_EOL .
        "\t\t" . "\$params = json_decode(\$request->getContent());" . PHP_EOL . 
        "\t\t" . "if(\$params){" . PHP_EOL .
        "\t\t\t" . "foreach(\$params as \$key => \$value){" . PHP_EOL .
        "\t\t\t\t" . "\$item->{\$key} = \$value;" . PHP_EOL . 
        "\t\t\t" . "}" . PHP_EOL . 
        "\t\t\t" . "\$item->save();" . PHP_EOL . PHP_EOL . 
        "\t\t\t" . "return Response::json(['data' => \$item, 'status' => 'success', 'msg' => 'item saved successfully'], 200);" . PHP_EOL .
        "\t\t" . "}" . PHP_EOL . PHP_EOL . 
        "\t\t" . "return Response::json(['msg' => 'something went wrong', 'status' => 'error'], 505);" . PHP_EOL . 
        "\t" . "}" . PHP_EOL . PHP_EOL;
        return $update;
    }

    private function getStoreMethod(): string
    {
        $store = "\t" . "/**" . PHP_EOL .
        "\t" . "* Store $this->nameSpace" . PHP_EOL .
        "\t" . "*" . PHP_EOL .
        "\t" . "* @param  \Illuminate\Http\Request \$request (POST Method)" . PHP_EOL .
        "\t" . "* @return \Illuminate\Http\Response" . PHP_EOL .
        "\t" . "*/" . PHP_EOL . //END OF PARAMETER
        "\t" . 'public function store(Request $request): JsonResponse' . PHP_EOL .
        "\t{" . PHP_EOL .
        "\t\t" . "\$item = new $this->nameSpace;" . PHP_EOL . "\t" . PHP_EOL .
        "\t\t" . "\$params = json_decode(\$request->getContent());" . PHP_EOL . 
        "\t\t" . "if(\$params){" . PHP_EOL .
        "\t\t\t" . "foreach(\$params as \$key => \$value){" . PHP_EOL .
        "\t\t\t\t" . "\$item->{\$key} = \$value;" . PHP_EOL . 
        "\t\t\t" . "}" . PHP_EOL . PHP_EOL . 
        "\t\t\t" . "\$item->save();" . PHP_EOL .
        "\t\t\t" . "return Response::json(['data' => \$item, 'status' => 'success', 'msg' => 'item saved successfully'], 200);" . PHP_EOL .
        "\t\t" . "}" . PHP_EOL . PHP_EOL . 
        "\t\t" . "return Response::json(['msg' => 'something went wrong', 'status' => 'error'], 505);" . PHP_EOL . 
        "\t" . "}" . PHP_EOL . PHP_EOL;
        return $store;
    }

    private function getDestroyMethod(): string
    {
         $destroy =  "\t" . "/**" . PHP_EOL .
         "\t" . "* Delete $this->nameSpace" . PHP_EOL .
         "\t" . "*" . PHP_EOL .
         "\t" . "* @param  \Illuminate\Http\Request \$request (Delete Method)" . PHP_EOL .
         "\t" . "* @return \Illuminate\Http\Response" . PHP_EOL .
         "\t" . "*/" . PHP_EOL . //END OF PARAMETER
         "\t" . 'public function destroy(Request $request, int $id): JsonResponse' . PHP_EOL .
         "\t{" . PHP_EOL .
         "\t\t" . "\$item = $this->nameSpace::findorFail" . '($id);' . PHP_EOL .
         "\t\t" . "if(\$item->delete()){" . PHP_EOL .
         "\t\t\t" . "return Response::json(['status' => 'success', 'msg' => 'Item has been removed successfully'], 200);" . PHP_EOL .
         "\t\t" . "}" . PHP_EOL . PHP_EOL .
         "\t\t" . "return Response::json(['msg' => 'something went wrong', 'status' => 'error'], 505);" . PHP_EOL . 
         "\t" . "}" . PHP_EOL . PHP_EOL;
         return $destroy;
    }
}