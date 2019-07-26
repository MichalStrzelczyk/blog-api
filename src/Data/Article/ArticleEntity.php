<?php
declare(strict_types=1);

namespace Data\Article;

class ArticleEntity extends \Maleficarum\Data\Model\Persistable\AbstractModel implements \Data\Container\ErrorContainerInterface{
    const STATUS_ACTIVE   = 1;
    const STATUS_INACTIVE = 0;

    /** @var int */
    private $articleId;

    /** @var string */
    private $articleTitle;

    /** @var string */
    private $articleRoute;

    /** @var string */
    private $articleDescription;

    /** @var int */
    private $articleStatus;

    /** @var string */
    private $articleCreatedDate;

    /**
     * @depracated
     */
    public function validate(bool $clear = true): bool {
        return false;
    }

    /**
     * @see \Maleficarum\Data\Model\Persistable\AbstractModel::getDomainGroup()
     */
    public function getDomainGroup(): string {
        return 'blog';
    }

    /**
     * @see \Maleficarum\Data\Model\Persistable\AbstractModel::getModelPrefix()
     */
    public function getModelPrefix(): string {
        return 'article';
    }

    /**
     * @see \Maleficarum\Data\Model\Persistable\AbstractModel::getStorageGroup()
     */
    public function getStorageGroup(): string {
        return '[blog]articles';
    }

    /**
     * @return int|null
     */
    public function getArticleId(): ?int {
        return $this->articleId;
    }

    /**
     * @param int $articleId
     *
     * @return ArticleEntity
     */
    public function setArticleId($articleId): ArticleEntity {
        $this->articleId = $articleId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getArticleTitle(): ?string {
        return $this->articleTitle;
    }

    /**
     * @param string $articleTitle
     *
     * @return ArticleEntity
     */
    public function setArticleTitle($articleTitle): ArticleEntity {
        $this->articleTitle = $articleTitle;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getArticleRoute(): ?string {
        return $this->articleRoute;
    }

    /**
     * @param string $articleRoute
     *
     * @return ArticleEntity
     */
    public function setArticleRoute($articleRoute): ArticleEntity {
        $this->articleRoute = $articleRoute;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getArticleDescription(): ?string {
        return $this->articleDescription;
    }

    /**
     * @param string $articleDescription
     *
     * @return ArticleEntity
     */
    public function setArticleDescription($articleDescription): ArticleEntity {
        $this->articleDescription = $articleDescription;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getArticleStatus(): ?int {
        return $this->articleStatus;
    }

    /**
     * @param int $articleStatus
     *
     * @return ArticleEntity
     */
    public function setArticleStatus($articleStatus): ArticleEntity {
        $this->articleStatus = $articleStatus;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getArticleCreatedDate(): ?string {
        return $this->articleCreatedDate;
    }

    /**
     * @param string $articleCreatedDate
     *
     * @return ArticleEntity
     */
    public function setArticleCreatedDate($articleCreatedDate): ArticleEntity {
        $this->articleCreatedDate = $articleCreatedDate;

        return $this;
    }
}
