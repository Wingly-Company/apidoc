<?php

namespace Wingly\ApiDoc;

use Illuminate\Support\Str;
use ReflectionAttribute;
use ReflectionClass;
use SplFileInfo;
use Symfony\Component\Finder\Finder;
use Throwable;
use Wingly\ApiDoc\Attributes\ApiDocAttribute;
use Wingly\ApiDoc\Attributes\Authenticated;
use Wingly\ApiDoc\Attributes\Group;
use Wingly\ApiDoc\Attributes\Parameter;
use Wingly\ApiDoc\Attributes\Response;
use Wingly\ApiDoc\Attributes\Route;

class DocumentationGenerator
{
    public $basePath;

    public $rootNamespace;

    public $writer;

    public function __construct()
    {
        $this->basePath = app()->path();

        $this->writer = new Writer();
    }

    public function useBasePath(string $basePath): self
    {
        $this->basePath = $basePath;

        return $this;
    }

    public function useRootNamespace(string $rootNamespace): self
    {
        $this->rootNamespace = $rootNamespace;

        return $this;
    }

    public function registerDirectory(string $directory): void
    {
        $files = (new Finder())->files()->name('*.php')->in($directory);

        collect($files)->each(fn (SplFileInfo $file) => $this->registerFile($file));
    }

    public function registerFile(string | SplFileInfo $path): void
    {
        if (is_string($path)) {
            $path = new SplFileInfo($path);
        }

        $fullyQualifiedClassName = $this->fullQualifiedClassNameFromFile($path);

        $this->processAttributes($fullyQualifiedClassName);
    }

    public function registerClass(string $class): void
    {
        $this->processAttributes($class);
    }

    protected function fullQualifiedClassNameFromFile(SplFileInfo $file): string
    {
        $class = trim(Str::replaceFirst($this->basePath, '', $file->getRealPath()), DIRECTORY_SEPARATOR);

        $class = str_replace(
            [DIRECTORY_SEPARATOR, 'App\\'],
            ['\\', app()->getNamespace()],
            ucfirst(Str::replaceLast('.php', '', $class))
        );

        return $this->rootNamespace . $class;
    }

    protected function processAttributes(string $className): void
    {
        if (! class_exists($className)) {
            return;
        }

        $class = new ReflectionClass($className);

        $classApiDocAttributes = new ClassApiDocAttributes($class);

        foreach ($class->getMethods() as $method) {
            $attributes = $method->getAttributes(ApiDocAttribute::class, ReflectionAttribute::IS_INSTANCEOF);

            if (! count($attributes)) {
                continue;
            }

            $endpoint = new Endpoint();

            if ($group = $classApiDocAttributes->group()) {
                $endpoint->group = $group;
            }

            if ($classApiDocAttributes->authenticated()) {
                $endpoint->authenticated = true;
            }

            foreach ($attributes as $attribute) {
                try {
                    $attributeClass = $attribute->newInstance();
                } catch (Throwable $th) {
                    continue;
                }

                if ($attributeClass instanceof Route) {
                    $endpoint->route = $attributeClass;
                }

                if ($attributeClass instanceof Authenticated) {
                    $endpoint->authenticated = true;
                }

                if ($attributeClass instanceof Group) {
                    $endpoint->group = $attributeClass->group;
                }

                if ($attributeClass instanceof Parameter) {
                    $endpoint->addParameter($attributeClass);
                }

                if ($attributeClass instanceof Response) {
                    $endpoint->addResponse($attributeClass);
                }
            }

            foreach ($method->getParameters() as $parameter) {
                $paramAttribute = $parameter->getAttributes(ApiDocAttribute::class, ReflectionAttribute::IS_INSTANCEOF)[0] ?? null;

                if (! $paramAttribute) {
                    continue;
                }

                $paramAttributeClass = $paramAttribute->newInstance();

                if ($paramAttributeClass instanceof Parameter) {
                    $endpoint->addParameter($paramAttributeClass);
                }
            }

            $this->writer->addEndpoint($endpoint);
        }
    }

    public function writeDocs()
    {
        $this->writer->generate();
    }
}
