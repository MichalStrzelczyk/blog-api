<?php
declare(strict_types=1);

namespace Data\ArticleToCategory;

/**
 * Class Collection
 *
 * @package Data\Article
 */
class Collection extends \Maleficarum\Data\Collection\Persistable\AbstractCollection {

    use \Maleficarum\Data\Container\Error\Container;

    /**
     * @see \Maleficarum\Data\Collection\Persistable\AbstractCollection::validate()
     */
    public function validate(bool $clear = true): bool {
        return true;
    }

    /**
     * @see \Maleficarum\Data\Collection\Persistable\AbstractCollection::getDomainGroup()
     */
    public function getDomainGroup(): string {
        return 'mapArticleCategory';
    }

    /**
     * @see \Maleficarum\Data\Collection\Persistable\AbstractCollection::getModelPrefix()
     */
    public function getModelPrefix(): string {
        return 'mapArticleCategory';
    }

    /**
     * @see \Maleficarum\Data\Collection\Persistable\AbstractCollection::getStorageGroup()
     */
    public function getStorageGroup(): string {
        return '[blog]map-articles_categories';
    }

}
