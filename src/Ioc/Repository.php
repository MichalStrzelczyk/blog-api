<?php
declare(strict_types=1);

\Maleficarum\Ioc\Container::registerBuilder('Repository', function($dep, $opts) {
    $repository =  new $opts['__class'];
    $repository->setStorage($dep['Maleficarum\Storage']);

    return $repository;
});