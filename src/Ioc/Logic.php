<?php
declare(strict_types=1);

\Maleficarum\Ioc\Container::registerBuilder(\Logic\Article\Crud\CrudManager::class, function ($dep, $opts) {
    $repository = \Maleficarum\Ioc\Container::get(\Repository\Article\Postgresql\PostgresqlEntity::class);
    $manager = new \Logic\Article\Crud\CrudManager($repository);

    return $manager;
});

\Maleficarum\Ioc\Container::registerBuilder(\Logic\Article\ArticleManager::class, function ($dep, $opts) {
    $articleCrudManager = \Maleficarum\Ioc\Container::get(\Logic\Article\Crud\CrudManager::class);
    $articleRpositoryEntity = \Maleficarum\Ioc\Container::get(\Repository\Article\Postgresql\PostgresqlEntity::class);
    $articleRepositoryCollection = \Maleficarum\Ioc\Container::get(\Repository\Article\Postgresql\PostgresqlCollection::class);
    $articleToCategoryRepositoryCollection = \Maleficarum\Ioc\Container::get(\Repository\ArticleToCategory\Postgresql\PostgresqlCollection::class);

    $manager = new \Logic\Article\ArticleManager($articleCrudManager, $articleRpositoryEntity, $articleRepositoryCollection, $articleToCategoryRepositoryCollection);

    return $manager;
});

