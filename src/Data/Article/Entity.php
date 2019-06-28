<?php

declare(strict_types=1);

namespace Data\Article;

/**
 * Class Entity
 *
 * @package Data\Article
 */
class Entity extends \Maleficarum\Data\Model\Persistable\AbstractModel {

    const STATUS_ACTIVE   = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @var int
     */
    private $articleId;

    /**
     * @var string
     */
    private $articleTitle;

    /**
     * @var string
     */
    private $articleRoute;

    /**
     * @var string
     */
    private $articleDescription;

    /**
     * @var int
     */
    private $articleActive;

    /**
     * @var string
     */
    private $articleCreatedDate;

    /**
     * @see \Maleficarum\Data\Model\Persistable\AbstractModel::validate()
     */
    public function validate(bool $clear = true): bool {
        if ($clear) {
            $this->clearErrors();
        }

        return \Data\Article\Validator::validate($this->getDTO(), $this);
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
     * @return int
     */
    public function getArticleId(): ?int {
        return $this->articleId;
    }

    /**
     * @param int $articleId
     *
     * @return Entity
     */
    public function setArticleId($articleId): Entity {
        $this->articleId = $articleId;

        return $this;
    }

    /**
     * @return string
     */
    public function getArticleTitle(): ?string {
        return $this->articleTitle;
    }

    /**
     * @param string $articleTitle
     *
     * @return Entity
     */
    public function setArticleTitle($articleTitle): Entity {
        $this->articleTitle = $articleTitle;

        return $this;
    }

    /**
     * @return string
     */
    public function getArticleRoute(): ?string {
        return $this->articleRoute;
    }

    /**
     * @param string $articleRoute
     *
     * @return Entity
     */
    public function setArticleRoute($articleRoute): Entity {
        $this->articleRoute = $articleRoute;

        return $this;
    }

    /**
     * @return string
     */
    public function getArticleDescription(): ?string {
        return $this->articleDescription;
    }

    /**
     * @param string $articleDescription
     *
     * @return Entity
     */
    public function setArticleDescription($articleDescription): Entity {
        $this->articleDescription = $articleDescription;

        return $this;
    }

    /**
     * @return int
     */
    public function getArticleActive(): ?int {
        return $this->articleActive;
    }

    /**
     * @param int $articleActive
     *
     * @return Entity
     */
    public function setArticleActive($articleActive): Entity {
        $this->articleActive = $articleActive;

        return $this;
    }

    /**
     * @return string
     */
    public function getArticleCreatedDate(): ?string {
        return $this->articleCreatedDate;
    }

    /**
     * @param string $articleCreatedDate
     *
     * @return Entity
     */
    public function setArticleCreatedDate($articleCreatedDate): Entity {
        $this->articleCreatedDate = $articleCreatedDate;

        return $this;
    }
}
