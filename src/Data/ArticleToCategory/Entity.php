<?php
declare(strict_types=1);

namespace Data\ArticleToCategory;

/**
 * Class Entity
 *
 * @package Data\ArticleToCategory
 */
class Entity extends \Maleficarum\Data\Model\Persistable\AbstractModel {

    /**
     * @var int
     */
    private $mapArticleCategoryArticleId;

    /**
     * @var int
     */
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
     * @see \Maleficarum\Data\Model\Persistable\AbstractModel::validate()
     */
    public function validate(bool $clear = true): bool {

        return true;

        if ($clear) {
            $this->clearErrors();
        }

        return \Data\Article\Validator::validate($this->getDTO(), $this);
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
     * @return Entity
     */
    public function setMapArticleCategoryArticleId($mapArticleCategoryArticleId): Entity {
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
     * @return Entity
     */
    public function setMapArticleCategoryCategoryId($mapArticleCategoryCategoryId): Entity {
        $this->mapArticleCategoryCategoryId = $mapArticleCategoryCategoryId;

        return $this;
    }


}
