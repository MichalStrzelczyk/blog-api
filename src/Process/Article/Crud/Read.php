<?php
declare(strict_types=1);

namespace Process\Article\Crud;

class Read extends \Process\AbstractProcess {
    /** @var \Repository\Article\Postgresql\PostgresqlEntity  */
    private $articleRepository;

    /**
     * Read constructor.
     *
     * @param \Process\ResponseInterface $response
     * @param \Repository\Article\Postgresql\PostgresqlEntity $articleRepository
     */
    public function __construct(\Process\ResponseInterface $response, \Repository\Article\Postgresql\PostgresqlEntity $articleRepository) {
        $this->articleRepository = $articleRepository;

        parent::__construct($response);
    }

    /**
     * @inheritDoc
     */
    protected function validate(array $options = []) {
        if (!isset($options['articleId'])) {
            $this->getResponse()->addError('0001-000101','Parameter `articleId` is empty');
        }
    }

    /**
     * @inheritDoc
     */
    protected function execute(array $options = []) {
        /** @var \Data\Article\ArticleEntity $article */
        $article = \Maleficarum\Ioc\Container::get(\Data\Article\ArticleEntity::class);
        $article->setId($options['articleId']);
        $this->articleRepository->read($article);

        $this->getResponse()->setData(['article' => $article]);
    }
}