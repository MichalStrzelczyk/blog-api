<?php
declare(strict_types=1);

\Maleficarum\Ioc\Container::registerBuilder(\Controller\Article\ArticleController::class, function($dep, $opts) {
    $queryOptions = \Maleficarum\Ioc\Container::get(\Logic\QueryOptions\Article::class, [
        10, // limit
        100, // maxLimit,
        0, // offset
        '-date', // sort
        [
            '-status' => [['articleStatus', 'DESC']],
            '+status' => [['articleStatus', 'ASC']],
            '-date' => [['articleCreatedDate', 'DESC']],
            '+date' => [['articleCreatedDate', 'ASC']],
            '-id' => [['articleId', 'DESC']],
            '+id' => [['articleId', 'ASC']]

        ],
        [] // filters

    ]);
    $opts['__instance']->setQueryOptions($queryOptions);
    $opts['__instance']->setLogger($dep['Maleficarum\Logger']);

    return $opts['__instance'];
});

\Maleficarum\Ioc\Container::registerBuilder(\Controller\Article\Category\CategoryController::class, function($dep, $opts) {
    $opts['__instance']->setLogger($dep['Maleficarum\Logger']);

    return $opts['__instance'];
});

\Maleficarum\Ioc\Container::registerBuilder(\Controller\Article\Crud\CrudController::class, function($dep, $opts) {
    $opts['__instance']->setLogger($dep['Maleficarum\Logger']);

    return $opts['__instance'];
});