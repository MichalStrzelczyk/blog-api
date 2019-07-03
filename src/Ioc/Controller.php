<?php
declare(strict_types=1);

\Maleficarum\Ioc\Container::registerBuilder(\Controller\Article\ArticleController::class, function($dep, $opts) {
    $articleManager = \Maleficarum\Ioc\Container::get(\Logic\Article\ArticleManager::class);
    $opts['__instance']->setArticleManager($articleManager);
    $opts['__instance']->setLogger($dep['Maleficarum\Logger']);

    return $opts['__instance'];
});

\Maleficarum\Ioc\Container::registerBuilder(\Controller\Article\Category\CategoryController::class, function($dep, $opts) {
    $articleManager = \Maleficarum\Ioc\Container::get(\Logic\Article\ArticleManager::class);
    $opts['__instance']->setArticleManager($articleManager);
    $opts['__instance']->setLogger($dep['Maleficarum\Logger']);

    return $opts['__instance'];
});

\Maleficarum\Ioc\Container::registerBuilder(\Controller\Article\Crud\CrudController::class, function($dep, $opts) {
    $articleCrudManager = \Maleficarum\Ioc\Container::get(\Logic\Article\Crud\CrudManager::class);
    $opts['__instance']->setArticleCrudManager($articleCrudManager);
    $opts['__instance']->setLogger($dep['Maleficarum\Logger']);

    return $opts['__instance'];
});

