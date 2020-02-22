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
   }
}