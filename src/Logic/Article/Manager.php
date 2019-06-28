<?php
declare(strict_types=1);

namespace Logic\Article;

/**
 * Class Manager
 *
 * @package Logic\Article
 */
class Manager {
    /**
     * @var \Repository\Article\Postgresql\Collection
     */
    protected $articleCollectionRepository;

    /**
     * @var \Repository\Article\Postgresql\Entity
     */
    protected $articleEntityRepository;

    /**
     * @var \Repository\ArticleToCategory\Postgresql\Collection
     */
    protected $articleToCatoryCollectionRepository;

    /**
     * @var Crud\Manager
     */
    protected $articleCrudManager;

    /**
     * Manager constructor.
     *
     * @param \Repository\Article\Postgresql\Collection $articleRepository
     */
    public function __construct(
        \Logic\Article\Crud\Manager $articleCrudManager,
        \Repository\Article\Postgresql\Entity $articleEntityRepository,
        \Repository\Article\Postgresql\Collection $articleCollectionRepository,
        \Repository\ArticleToCategory\Postgresql\Collection $articleToCatoryCollectionRepository
    ) {
        $this->articleCrudManager = $articleCrudManager;
        $this->articleCollectionRepository = $articleCollectionRepository;
        $this->articleEntityRepository = $articleEntityRepository;
        $this->articleToCatoryCollectionRepository = $articleToCatoryCollectionRepository;
    }

    /**
     * List all articles
     *
     * @param array $parameters
     * @param array $subset
     *
     * @return \Data\Article\Collection
     */
    public function list($limit = 100, $offset = 0, $sorting = [], $filters = []): \Data\Article\Collection {
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

        $articleCollection = \Maleficarum\Ioc\Container::get(\Data\Article\Collection::class);
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
        $articleToCategoryCollection = \Maleficarum\Ioc\Container::get(\Data\ArticleToCategory\Collection::class);
        $parameters = [
            'mapArticleCategoryArticleId' => [$articleId]
        ];

        $this->articleToCatoryCollectionRepository->populate($articleToCategoryCollection, $parameters);

        try {
            $shard = $this->articleToCatoryCollectionRepository->getShard($articleToCategoryCollection);
            $shard->inTransaction() or $shard->beginTransaction();
            $articleToCategoryCollection->count() > 0 and $this->articleToCatoryCollectionRepository->deleteAll($articleToCategoryCollection);

            $data = [];
            \array_filter($categoryIds, function ($row) use (&$data, $article) {
                $data[] = [
                    'mapArticleCategoryArticleId' => $article->getArticleId(),
                    'mapArticleCategoryCategoryId' => $row,
                ];
            });

            $articleToCategoryCollection->clear()->setData($data);
            $articleToCategoryCollection->count() > 0 and $this->articleToCatoryCollectionRepository->createAll($articleToCategoryCollection);

            $shard->commit();
        } catch (\Exception $e) {
            $shard->rollback();

            throw $e;
        }


        return $articleToCategoryCollection;
    }
}