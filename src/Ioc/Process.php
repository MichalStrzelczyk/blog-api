<?php
declare(strict_types=1);

\Maleficarum\Ioc\Container::registerBuilder(\Process\Article\Crud\Create::class, function($dep, $opts) {
    $response = new \Process\Response();
    $repository = \Maleficarum\Ioc\Container::get(\Repository\Article\Postgresql\PostgresqlEntity::class);
    $process = new \Process\Article\Crud\Create($response, $repository);

    return $process;
});

\Maleficarum\Ioc\Container::registerBuilder(\Process\Article\Crud\Read::class, function($dep, $opts) {
    $response = new \Process\Response();
    $repository = \Maleficarum\Ioc\Container::get(\Repository\Article\Postgresql\PostgresqlEntity::class);
    $process = new \Process\Article\Crud\Read($response, $repository);

    return $process;
});

\Maleficarum\Ioc\Container::registerBuilder(\Process\Article\Crud\Update::class, function($dep, $opts) {
    $response = new \Process\Response();
    $repository = \Maleficarum\Ioc\Container::get(\Repository\Article\Postgresql\PostgresqlEntity::class);
    $readProcess = \Maleficarum\Ioc\Container::get(\Process\Article\Crud\Read::class);
    $process = new \Process\Article\Crud\Update($response, $repository, $readProcess);

    return $process;
});

\Maleficarum\Ioc\Container::registerBuilder(\Process\Article\Crud\Delete::class, function($dep, $opts) {
    $response = new \Process\Response();
    $repository = \Maleficarum\Ioc\Container::get(\Repository\Article\Postgresql\PostgresqlEntity::class);
    $readProcess = \Maleficarum\Ioc\Container::get(\Process\Article\Crud\Read::class);
    $process = new \Process\Article\Crud\Delete($response, $repository, $readProcess);

    return $process;
});

\Maleficarum\Ioc\Container::registerBuilder(\Process\Article\ReadAll::class, function($dep, $opts) {
    $response = new \Process\Response();
    $repository = \Maleficarum\Ioc\Container::get(\Repository\Article\Postgresql\PostgresqlCollection::class);
    $process = new \Process\Article\ReadAll($response, $repository);

    return $process;
});

\Maleficarum\Ioc\Container::registerBuilder(\Process\Article\AttachToCategories::class, function($dep, $opts) {
    $response = new \Process\Response();
    $readProcess = \Maleficarum\Ioc\Container::get(\Process\Article\Crud\Read::class);
    //$repository = \Maleficarum\Ioc\Container::get(\Repository\Article\Postgresql\PostgresqlEntity::class);

    $articleToCategoryCollectionRepository = \Maleficarum\Ioc\Container::get(\Repository\ArticleToCategory\Postgresql\PostgresqlCollection::class);

    $process = new \Process\Article\AttachToCategories($response, $readProcess, $articleToCategoryCollectionRepository);

    return $process;
});