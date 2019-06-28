<?php
/**
 * Route definitions for the /status resource
 */
declare(strict_types=1);

$app->map('/status', function () {
    \Maleficarum\Ioc\Container::get('Controller\Status\Controller')->__remap('get');
})->via(['GET']);
