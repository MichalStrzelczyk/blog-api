<?php
declare(strict_types=1);

namespace Logic\Article\Crud;

class CrudManager {
    /** @var \Repository\Article\Postgresql\PostgresqlEntity  */
    protected $articleRepository;

    /**
     * Manager constructor.
     *
     * @param \Repository\Article\Postgresql\PostgresqlEntity $articleRepository
     */
    public function __construct(\Repository\Article\Postgresql\PostgresqlEntity $articleRepository) {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Create new entity
     *
     * @param array $data
     *
     * @return \Data\Article\ArticleEntity
     */
    public function create(array $data): \Data\Article\ArticleEntity {
        /** @var \Data\Article\ArticleEntity $article */
        $article = \Maleficarum\Ioc\Container::get(\Data\Article\ArticleEntity::class);
        $article->merge($data);
        $article->setArticleCreatedDate(date('Y-m-d H:i:s'));
        $article->setarticleStatus(\Data\Article\ArticleEntity::STATUS_ACTIVE);

        \Data\Article\ArticleValidator::validate($article->getDTO(), $article);
        if ($article->hasErrors()) {
            throw new \Logic\Exception\EntityValidationError($article->getAllErrors());
        }

        $this->articleRepository->create($article);

        return $article;
    }

    /**
     * Read entity
     *
     * @param int $articleId
     *
     * @throws \Maleficarum\Storage\Exception\Repository\EntityNotFoundException
     *
     * @return \Data\Article\ArticleEntity
     */
    public function read(int $articleId): \Data\Article\ArticleEntity {
        /** @var \Data\Article\ArticleEntity $article */
        $article = \Maleficarum\Ioc\Container::get(\Data\Article\ArticleEntity::class);
        $article->setId($articleId);
        $this->articleRepository->read($article);

        return $article;
    }

    /**
     * Update
     *
     * @param int $articleId
     * @param array $data
     *
     * @throws \Maleficarum\Storage\Exception\Repository\EntityNotFoundException
     *
     * @return \Data\Article\ArticleEntity
     */
    public function update(int $articleId, array $data): \Data\Article\ArticleEntity {
        $article = $this->read($articleId);

        // This properties shouldn't be changed
        unset($data['articleCreatedDate']);
        unset($data['articleId']);

        $article->merge($data);
        \Data\Article\ArticleValidator::validate($article->getDTO(), $article);
        if ($article->hasErrors()) {
            throw new \Logic\Exception\EntityValidationError($article->getAllErrors());
        }

        $this->articleRepository->update($article);

        return $article;
    }

    /**
     * Delete
     *
     * @param int $articleId
     *
     * @throws \Maleficarum\Storage\Exception\Repository\EntityNotFoundException
     */
    public function delete(int $articleId): void {
        $article = $this->read($articleId);

        $this->articleRepository->delete($article);
    }
}