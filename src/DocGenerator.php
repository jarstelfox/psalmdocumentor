<?php

namespace PsalmDocumentor;

use PhpParser\Comment\Doc;
use Psalm\Codebase;
use Psalm\CodeLocation;
use Psalm\Storage\ClassLikeStorage;

class DocGenerator {

   /**
    * @psalm-readonly
    * @psalm-var Codebase
    */
   private $codebase;

   /**
    * @psalm-readonly
    * @psalm-var array<string, ClassLikeStorage>
    */
   private $classMap;

   public function __construct(Codebase $codebase){
      $this->codebase = $codebase;
      $this->classMap = $codebase->classlike_storage_provider->getAll();
   }

   public function generateDocs(): void {
      foreach ($this->getIncludedClasses() as $classLike) {
         $methods = $classLike->methods;
         foreach ($methods as $methodLike) {
            $doc = $this->getDocComment($methodLike->stmt_location);
            var_dump([
               'fullClassName' => $classLike->name,
               'methodName' => $methodLike->cased_name,
               'docBlockText' => $doc ? $doc->getText() : '',
            ]);
         }
      }
   }

   /**
    * @return ClassLikeStorage[]
    */
   private function getIncludedClasses(): array {
      return array_filter($this->classMap, function ($classLike) {
         return !$this->isClassExcluded($classLike);
      });
   }

   private function isClassExcluded(ClassLikeStorage $classLike): bool {
      $codeLocation = $classLike->namespace_name_location;
      return $this->isBarePhp($codeLocation) ||
             $this->isInVendor($codeLocation);
   }

   private function isInVendor(?CodeLocation $codeLocation): bool {
      $filePath = $codeLocation ? $codeLocation->file_path : '';
      $isVendor = (bool)strstr($filePath, 'vendor');
      return $isVendor;
   }

   private function isBarePhp(?CodeLocation $codeLocation): bool {
      return $codeLocation === null;
   }

   private function getDocComment(?CodeLocation $codeLocation): ?Doc {
      return null;
   }
}