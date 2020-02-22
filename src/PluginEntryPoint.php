<?php
namespace Psalm\Example\Plugin\ComposerBased;

use Psalm\Plugin;
use SimpleXMLElement;
use PsalmDocumentor\DocGeneratorPlugin;

class PluginEntryPoint implements Plugin\PluginEntryPointInterface
{
    /** @return void */
    public function __invoke(Plugin\RegistrationInterface $registration, ?SimpleXMLElement $config = null)
    {
        require_once __DIR__ . '/DocGenerator.php';
        $registration->registerHooksFromClass(DocGeneratorPlugin::class);
    }
}