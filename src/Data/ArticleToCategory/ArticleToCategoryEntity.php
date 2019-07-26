<?php
declare(strict_types=1);

namespace Data\ArticleToCategory;

class ArticleToCategoryEntity extends \Maleficarum\Data\Model\Persistable\AbstractModel implements \Data\Container\ErrorContainerInterface{

    /** @var int */
    private $mapArticleCategoryArticleId;

    /** @var int */
    private $mapArticleCategoryCategoryId;

    /**
     * @return array|mixed
     */
    public function getId() {
        return [$this->getMapArticleCategoryArticleId(), $this->getMapArticleCategoryCategoryId()];
    }

    /**
     * Set id
     *
     * @param $ids
     *
     * @return $this|\Maleficarum\Data\Model\AbstractModel
     */
    public function setId($ids) {
        $this->setMapArticleCategoryArticleId($ids['articleId']);
        $this->setMapArticleCategoryCategoryId($ids['categoryId']);

        return $this;
    }

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
        return 'mapArticleCategory';
    }

    /**
     * @see \Maleficarum\Data\Model\Persistable\AbstractModel::getModelPrefix()
     */
    public function getModelPrefix(): string {
        return 'mapArticleCategory';
    }

    /**
     * @see \Maleficarum\Data\Model\Persistable\AbstractModel::getStorageGroup()
     */
    public function getStorageGroup(): string {
        return '[blog]map-articles_categories';
    }

    /**
     * @return int
     */
    public function getMapArticleCategoryArticleId(): ?int {
        return $this->mapArticleCategoryArticleId;
    }

    /**
     * @param int $mapArticleCategoryArticleId
     *
     * @return ArticleToCategoryEntity
     */
    public function setMapArticleCategoryArticleId($mapArticleCategoryArticleId): ArticleToCategoryEntity {
        $this->mapArticleCategoryArticleId = $mapArticleCategoryArticleId;

        return $this;
    }

    /**
     * @return int
     */
    public function getMapArticleCategoryCategoryId(): int {
        return $this->mapArticleCategoryCategoryId;
    }

    /**
     * @param int $mapArticleCategoryCategoryId
     *
     * @return ArticleToCategoryEntity
     */
    public function setMapArticleCategoryCategoryId($mapArticleCategoryCategoryId): ArticleToCategoryEntity {
        $this->mapArticleCategoryCategoryId = $mapArticleCategoryCategoryId;

        return $this;
    }


}
