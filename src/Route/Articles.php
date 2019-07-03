<?php
declare(strict_types=1);

/** @var \Maleficarum\Request\Request $request */
$app->map('/articles', function () use ($request) {

    if ($request->isPost()) {
        $controller = \Maleficarum\Ioc\Container::get(\Controller\Article\Crud\CrudController::class);
        $controller->__remap('create');
    }

    if ($request->isGet()) {
        $controller = \Maleficarum\Ioc\Container::get(\Controller\Article\ArticleController::class);
        $controller->__remap('list');
    }
})->via(['GET','POST']);

/** @var \Maleficarum\Request\Request $request */
$app->map('/articles/{articleId:\d+}', function ($articleId) use ($request) {
    $controller = \Maleficarum\Ioc\Container::get(\Controller\Article\Crud\CrudController::class);
    $request->attachUrlParams(['articleId' => $articleId]);

    if ($request->isGet()) {
        $controller->__remap('read');
    }

    if ($request->isPatch()) {
        $controller->__remap('update');
    }

    if ($request->isDelete()) {
        $controller->__remap('delete');
    }

})->via(['GET','PATCH','DELETE']);

/** @var \Maleficarum\Request\Request $request */
$app->map('/articles/{articleId:\d+}/categories', function ($articleId) use ($request) {
    $controller = \Maleficarum\Ioc\Container::get(\Controller\Article\Category\CategoryController::class);
    $request->attachUrlParams(['articleId' => $articleId]);

    if ($request->isPut()) {
        $controller->__remap('assign');
    }
})->via(['PUT']);