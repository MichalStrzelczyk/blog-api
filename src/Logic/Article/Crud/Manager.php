<?php
declare(strict_types=1);

namespace Logic\Article\Crud;

class Manager {
    /**
     * @var \Repository\Article\Postgresql\Entity
     */
    protected $articleRepository;

    /**
     * Manager constructor.
     *
     * @param \Repository\Article\Postgresql\Entity $articleRepository
     */
    public function __construct(\Repository\Article\Postgresql\Entity $articleRepository) {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Create new entity
     *
     * @param array $data
     *
     * @return \Data\Article\Entity
     */
    public function create(array $data): \Data\Article\Entity {
        /** @var \Data\Article\Entity $article */
        $article = \Maleficarum\Ioc\Container::get(\Data\Article\Entity::class);
        $article->merge($data);
        $article->setArticleCreatedDate(date('Y-m-d H:i:s'));
        $article->setArticleActive(\Data\Article\Entity::STATUS_ACTIVE);

        if (!$article->validate()) {
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
     * @return \Data\Article\Entity
     *
     * @throws \Maleficarum\Storage\Exception\Repository\EntityNotFoundException
     */
    public function read(int $articleId): \Data\Article\Entity {
        /** @var \Data\Article\Entity $article */
        $article = \Maleficarum\Ioc\Container::get(\Data\Article\Entity::class);
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
     * @return \Data\Article\Entity
     *
     * @throws \Maleficarum\Storage\Exception\Repository\EntityNotFoundException
     */
    public function update(int $articleId, array $data): \Data\Article\Entity {
        $article = $this->read($articleId);

        // This properties shouldn't be changed
        unset($data['articleCreatedDate']);
        unset($data['articleId']);

        $article->merge($data);
        if (!$article->validate()) {
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
     * @return \Maleficarum\Storage\Repository\ModelInterface
     *
     * @throws \Maleficarum\Storage\Exception\Repository\EntityNotFoundException
     */
    public function delete(int $articleId) {
        $article = $this->read($articleId);

        return $this->articleRepository->delete($article);
    }
}