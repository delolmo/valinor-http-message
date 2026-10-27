<?php

declare(strict_types=1);

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

$config = new Configuration();

$config->disableComposerAutoloadPathScan();

$config->addPathToScan(__DIR__ . '/src', isDev: false);

$config->addPathToScan(__DIR__ . '/tests', isDev: true);

// The source is built to be handed to Valinor, which the code never names;
// requiring it pins the Valinor major the source is tested against.
$config->ignoreErrorsOnPackage('cuyz/valinor', [ErrorType::PROD_DEPENDENCY_ONLY_IN_DEV]);

return $config;
