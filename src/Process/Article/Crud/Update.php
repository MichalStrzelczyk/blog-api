<?php
declare(strict_types=1);

namespace Process\Article\Crud;

class Update extends \Process\AbstractProcess {
    /** @var \Repository\Article\Postgresql\PostgresqlEntity  */
    private $articleRepository;

    /**
     * Update constructor.
     *
     * @param \Process\ResponseInterface $response
     * @param \Repository\Article\Postgresql\PostgresqlEntity $articleRepository
     * @param Read $readProcess
     */
    public function __construct(
        \Process\ResponseInterface $response,
        \Repository\Article\Postgresql\PostgresqlEntity $articleRepository,
        \Process\Article\Crud\Read $readProcess
    ) {
        $this->articleRepository = $articleRepository;
        $this->readProcess = $readProcess;

        parent::__construct($response);
    }

    /**
     * @inheritDoc
     */
    protected function validate(array $options = []) {
        if (!isset($options['articleData'])) {
            $this->getResponse()->addError('0001-000100','Parameter `articleData` is empty');
        }

        if (!isset($options['articleId'])) {
            $this->getResponse()->addError('0001-000101','Parameter `articleId` is empty');
        }
    }

    /**
     * @inheritDoc
     */
    protected function execute(array $options = []) {
        $article = $this->readProcess->handle($options)->getData()['article'];

        // This properties shouldn't be changed
        unset($options['articleData']['articleCreatedDate']);
        unset($options['articleData']['articleId']);

        $article->merge($options['articleData']);
        \Data\Article\ArticleValidator::validate($article->getDTO(), $article);
        if ($article->hasErrors()) {
            throw new \Logic\Exception\EntityValidationError($article->getAllErrors());
        }

        $this->articleRepository->update($article);
        $this->getResponse()->setData(['article' => $article]);
    }
}