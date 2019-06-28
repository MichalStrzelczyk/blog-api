<?php
declare(strict_types=1);

\Maleficarum\Ioc\Container::registerBuilder(\Logic\Article\Crud\Manager::class, function ($dep, $opts) {
    $repository = \Maleficarum\Ioc\Container::get(\Repository\Article\Postgresql\Entity::class);
    $manager = new \Logic\Article\Crud\Manager($repository);

    return $manager;
});

\Maleficarum\Ioc\Container::registerBuilder(\Logic\Article\Manager::class, function ($dep, $opts) {
    $articleCrudManager = \Maleficarum\Ioc\Container::get(\Logic\Article\Crud\Manager::class);
    $articleRpositoryEntity = \Maleficarum\Ioc\Container::get(\Repository\Article\Postgresql\Entity::class);
    $articleRepositoryCollection = \Maleficarum\Ioc\Container::get(\Repository\Article\Postgresql\Collection::class);
    $articleToCategoryRepositoryCollection = \Maleficarum\Ioc\Container::get(\Repository\ArticleToCategory\Postgresql\Collection::class);

    $manager = new \Logic\Article\Manager($articleCrudManager, $articleRpositoryEntity, $articleRepositoryCollection, $articleToCategoryRepositoryCollection);

    return $manager;
});

