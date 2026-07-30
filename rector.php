<?php

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Symfony\Set\SymfonySetList;
use Rector\ValueObject\PhpVersion;

try {
    return RectorConfig::configure()
        ->withPhpVersion(PhpVersion::PHP_83)
        ->withPaths([
            __DIR__ . '/src',
        ])
        ->withPhpSets(php85: true)
        // here we can define, what prepared sets of rules will be applied
        ->withPreparedSets(deadCode: true, codeQuality: true, doctrineCodeQuality: true, symfonyCodeQuality: true)
        ->withAttributesSets(symfony: true, doctrine: true)
        ->withSymfonyContainerXml(__DIR__ . '/var/cache/dev/App_KernelDevDebugContainer.xml')
        ->withComposerBased(symfony: true)
        ->withSets([
            LevelSetList::UP_TO_PHP_83,
            SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
        ]);
} catch (\Rector\Exception\Configuration\InvalidConfigurationException $e) {
    echo "Rector configuration error: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
