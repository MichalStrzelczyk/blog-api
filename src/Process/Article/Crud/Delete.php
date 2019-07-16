<?php
declare(strict_types=1);

namespace Process\Article\Crud;

class Delete extends \Process\AbstractProcess {
    /** @var \Repository\Article\Postgresql\PostgresqlEntity */
    private $articleRepository;

    /** @var \Process\Article\Crud\Read */
    private $readProcess;

    /**
     * Delete constructor.
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
        if (!isset($options['articleId'])) {
            $this->getResponse()->addError('0001-000101', 'Parameter `articleId` is empty');
        }
    }

    /**
     * @inheritDoc
     */
    protected function execute(array $options = []) {
        $article = $this->readProcess->handle($options)->getData()['article'];
        $this->articleRepository->delete($article);
    }
}