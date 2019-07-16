<?php
declare(strict_types=1);

namespace Process\Article\Crud;

class Create extends \Process\AbstractProcess {
    /** @var \Repository\Article\Postgresql\PostgresqlEntity */
    private $articleRepository;

    /**
     * Create constructor.
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
        if (!isset($options['articleData'])) {
            $this->getResponse()->addError('0001-000100','Parameter `articleData` is empty');
        }
    }

    /**
     * @inheritDoc
     */
    protected function execute(array $options = []) {
        /** @var \Data\Article\ArticleEntity $article */
        $article = \Maleficarum\Ioc\Container::get(\Data\Article\ArticleEntity::class);
        $article->merge($options['articleData']);
        $article->setArticleCreatedDate(date('Y-m-d H:i:s'));
        $article->setarticleStatus(\Data\Article\ArticleEntity::STATUS_ACTIVE);

        \Data\Article\ArticleValidator::validate($article->getDTO(), $article);
        if ($article->hasErrors()) {
            throw new \Process\Exception\ValidationError($article->getAllErrors());
        }

        $this->articleRepository->create($article);
        $this->getResponse()->setData(['article' => $article]);
    }
}