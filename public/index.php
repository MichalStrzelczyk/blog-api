<?php
declare(strict_types=1);
 
// initialize time profiling
$start = \microtime(true);
 
// define path constants
\define('CONFIG_PATH', \realpath('../config'));
\define('VENDOR_PATH', \realpath('../vendor'));
\define('SRC_PATH', \realpath('../src'));
 
// add vendor based autoloading
require_once VENDOR_PATH . '/autoload.php';
 
// create Phalcon micro application
$app = \Maleficarum\Ioc\Container::get('Phalcon\Mvc\Micro');
$app->getRouter()->setUriSource(\Phalcon\Mvc\Router::URI_SOURCE_SERVER_REQUEST_URI);

// Add namespaces for IOC
\Maleficarum\Ioc\Container::addNamespace('Controller', SRC_PATH . '/Ioc');
\Maleficarum\Ioc\Container::addNamespace('Logic', SRC_PATH . '/Ioc');
\Maleficarum\Ioc\Container::addNamespace('Repository', SRC_PATH . '/Ioc');

// create the bootstrap object and run internal init
$bootstrap = \Maleficarum\Ioc\Container::get('Maleficarum\Api\Bootstrap')
    ->setParamContainer([
        'app' => $app,
        'routes' => SRC_PATH . DIRECTORY_SEPARATOR . 'Route',
        'start' => $start,
        'builders' => [],
        'prefix' => 'miinto_blog-api',
        'logger.message_prefix' => '[PHP] '
    ])
    ->setInitializers([
        \Maleficarum\Api\Bootstrap::INITIALIZER_ERRORS,
        [\Maleficarum\Handler\Initializer\Initializer::class, 'initialize'],
        [\Maleficarum\Profiler\Initializer\Initializer::class, 'initializeTime'],
        [\Maleficarum\Environment\Initializer\Initializer::class, 'initialize'],
        \Maleficarum\Api\Bootstrap::INITIALIZER_DEBUG_LEVEL,
        [\Maleficarum\Config\Initializer\Initializer::class, 'initialize'],
        [Maleficarum\Request\Initializer\Initializer::class, 'initialize'],
        [\Maleficarum\Response\Initializer\Initializer::class, 'initialize'],
        [\Maleficarum\Logger\Initializer\Initializer::class, 'initialize'],
        \Maleficarum\Api\Bootstrap::INITIALIZER_CONTROLLER,
        \Maleficarum\Api\Bootstrap::INITIALIZER_SECURITY,
        \Maleficarum\Api\Bootstrap::INITIALIZER_ROUTES,
        [\Maleficarum\Storage\Internal\Initializer\Initializer::class, 'initialize'],
    ])
    ->initialize();

// run the app
$app->handle();
 
// conclude application run
$bootstrap->conclude();
