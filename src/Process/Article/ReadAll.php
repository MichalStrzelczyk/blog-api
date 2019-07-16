<?php
declare(strict_types=1);

namespace Process\Article;

class ReadAll extends \Process\AbstractProcess {
    /** @var \Repository\Article\Postgresql\PostgresqlCollection */
    protected $articleCollectionRepository;

    /**
     * Create constructor.
     *
     * @param array $data
     * @param \Repository\Article\Postgresql\PostgresqlEntity $articleRepository
     */
    public function __construct(
        \Process\ResponseInterface $response,
        \Repository\Article\Postgresql\PostgresqlCollection $articleCollectionRepository
    ) {
        $this->articleCollectionRepository = $articleCollectionRepository;

        parent::__construct($response);
    }

    /**
     * @inheritDoc
     */
    protected function validate(array $options = []) {
        if (!($options['queryOptions'] instanceof \Logic\QueryOptionsInterface)) {
            $this->getResponse()->addError('0001-000103', 'Parameter `queryOptions` is not a instance of \Logic\QueryOptionsInterface');
        }
    }

    /**
     * @inheritDoc
     */
    protected function execute(array $options = []) {
        $queryOptions = $options['queryOptions'];
        $parameters = [
            '__subset' => [
                'limit' => $queryOptions->getLimit(),
                'offset' => $queryOptions->getOffset(),
            ]
        ];

        if (!empty($queryOptions->getSorting())) {
            $parameters['__sorting'] = $queryOptions->getSorting();
        }

        if (!empty($queryOptions->getFilters())) {
            foreach ($queryOptions->getFilters() as $entityProperty => $entityValue) {
                $parameters[$entityProperty] = [$entityValue];
            }
        }

        $articleCollection = \Maleficarum\Ioc\Container::get(\Data\Article\ArticleCollection::class);
        $this->articleCollectionRepository->populate($articleCollection, $parameters);

        $this->getResponse()->setData($articleCollection->toArray());
    }
}