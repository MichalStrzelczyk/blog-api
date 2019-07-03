<?php

declare(strict_types=1);

$app->map('/status', function () {
    \Maleficarum\Ioc\Container::get(\Controller\Status\StatusController::class)->__remap('get');
})->via(['GET']);
