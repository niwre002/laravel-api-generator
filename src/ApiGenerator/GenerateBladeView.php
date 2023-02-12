<?php
namespace Erwinnerwin\LaravelApiGenerator\ApiGenerator;

use Erwinnerwin\LaravelApiGenerator\ApiGenerator\GenerateApiInterface;

class GenerateBladeView implements GenerateApiInterface
{
    private $nameSpace;

    public function __construct(String $nameSpace)
    {
        $this->nameSpace = $nameSpace;
    }

    public function generate(): string
    {
        return 'test';
    }
}