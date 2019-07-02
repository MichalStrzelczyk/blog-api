<?php
declare(strict_types=1);

namespace Logic\Article;

class ArticleManager {

    /** @var \Repository\Article\Postgresql\PostgresqlCollection  */
    protected $articleCollectionRepository;

    /** @var \Repository\Article\Postgresql\PostgresqlEntity  */
    protected $articleEntityRepository;

    /** @var \Repository\ArticleToCategory\Postgresql\PostgresqlCollection  */
    protected $articleToCategoryCollectionRepository;

    /** @var Crud\CrudManager  */
    protected $articleCrudManager;

    /**
     * ArticleManager constructor.
     *
     * @param Crud\CrudManager $articleCrudManager
     * @param \Repository\Article\Postgresql\PostgresqlEntity $articleEntityRepository
     * @param \Repository\Article\Postgresql\PostgresqlCollection $articleCollectionRepository
     * @param \Repository\ArticleToCategory\Postgresql\PostgresqlCollection $articleToCategoryCollectionRepository
     */
    public function __construct(
        \Logic\Article\Crud\CrudManager $articleCrudManager,
        \Repository\Article\Postgresql\PostgresqlEntity $articleEntityRepository,
        \Repository\Article\Postgresql\PostgresqlCollection $articleCollectionRepository,
        \Repository\ArticleToCategory\Postgresql\PostgresqlCollection $articleToCategoryCollectionRepository
    ) {
        $this->articleCrudManager = $articleCrudManager;
        $this->articleCollectionRepository = $articleCollectionRepository;
        $this->articleEntityRepository = $articleEntityRepository;
        $this->articleToCategoryCollectionRepository = $articleToCategoryCollectionRepository;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param array $sorting
     * @param array $filters
     * 
     * @return \Data\Article\ArticleCollection
     */
    public function list($limit = 100, $offset = 0, $sorting = [], $filters = []): \Data\Article\ArticleCollection {
        $parameters = [
            '__subset' => [
                'limit' => $limit,
                'offset' => $offset,
            ]
        ];

        if (!empty($sorting)) {
            $parameters['__sorting'] = $sorting;
        }

        if (!empty($filters)) {
            foreach ($filters as $entityProperty => $entityValue) {
                $parameters[$entityProperty] = [$entityValue];
            }
        }

        $articleCollection = \Maleficarum\Ioc\Container::get(\Data\Article\ArticleCollection::class);
        $this->articleCollectionRepository->populate($articleCollection, $parameters);

        return $articleCollection;
    }

    /**
     * Assign article to category
     *
     * @param $articleId
     * @param $categoryIds
     *
     * @return \Maleficarum\Storage\Repository\CollectionInterface
     *
     * @throws \Maleficarum\Storage\Exception\Repository\EntityNotFoundException
     */
    public function assignToCategories($articleId, $categoryIds) {
        $article = $this->articleCrudManager->read($articleId);
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
            \array_filter($categoryIds, function ($row) use (&$data, $article) {
                $data[] = [
                    'mapArticleCategoryArticleId' => $article->getArticleId(),
                    'mapArticleCategoryCategoryId' => $row,
                ];
            });

            $articleToCategoryCollection->clear()->setData($data);
            $articleToCategoryCollection->count() > 0 and $this->articleToCategoryCollectionRepository->createAll($articleToCategoryCollection);

            $shard->commit();
        } catch (\Exception $e) {
            $shard->rollback();

            throw $e;
        }

        return $articleToCategoryCollection;
    }
}