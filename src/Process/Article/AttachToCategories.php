<?php
declare(strict_types=1);

namespace Process\Article;

class AttachToCategories extends \Process\AbstractProcess {
    /** @var \Process\Article\Crud\Read */
    protected $readProcess;

    /** @var \Repository\ArticleToCategory\Postgresql\PostgresqlCollection */
    protected $articleToCategoryCollectionRepository;

    /**
     * AttachToCategories constructor.
     *
     * @param \Repository\Article\Postgresql\PostgresqlEntity $articleRepository
     * @param \Repository\ArticleToCategory\Postgresql\PostgresqlCollection $articleToCategoryCollectionRepository
     */
    public function __construct(
        \Process\ResponseInterface $response,
        \Process\Article\Crud\Read $readProcess,
        \Repository\ArticleToCategory\Postgresql\PostgresqlCollection $articleToCategoryCollectionRepository
    ) {
        $this->readProcess = $readProcess;
        $this->articleToCategoryCollectionRepository = $articleToCategoryCollectionRepository;

        parent::__construct($response);
    }

    /**
     * @inheritDoc
     */
    protected function validate(array $options = []) {
        if (!isset($options['articleId'])) {
            $this->getResponse()->addError('0001-000101','Parameter `articleId` is empty');
        }

        if (!isset($options['categoryIds'])) {
            $this->getResponse()->addError('0001-000101','Parameter `articleId` is empty');
        }
    }

    /**
     * @inheritDoc
     */
    protected function execute(array $options = []) {
        $articleId = $options['articleId'];
        $categoryIds = $options['categoryIds'];

        $article = $this->readProcess->handle(['articleId' => $articleId])->getData()['article'];
        $articleToCategoryCollection = \Maleficarum\Ioc\Container::get(\Data\ArticleToCategory\ArticleToCategoryCollection::class);
        $parameters = [
            'mapArticleCategoryArticleId' => [$articleId]
        ];

        $this->articleToCategoryCollectionRepository->populate($articleToCategoryCollection, $parameters);

        try {
            $shard = $this->articleToCategoryCollectionRepository->getShard($articleToCategoryCollection);
            $shard->inTransaction() or $shard->beginTransaction();
            $articleToCategoryCollection->count() > 0 and $this->articleToCategoryCollectionRepository->deleteAll($articleToCategoryCollection);

            $data = [];
            \array_filter($categoryIds, function ($categoryId) use (&$data, $article) {
                $data[] = [
                    'mapArticleCategoryArticleId' => $article->getArticleId(),
                    'mapArticleCategoryCategoryId' => $categoryId,
                ];
            });

            $articleToCategoryCollection->clear()->setData($data);
            $articleToCategoryCollection->count() > 0 and $this->articleToCategoryCollectionRepository->createAll($articleToCategoryCollection);

            $shard->commit();
        } catch (\Exception $e) {
            $shard->rollback();

            throw $e;
        }

        return $this->getResponse()->setData($articleToCategoryCollection->toArray());
    }
}