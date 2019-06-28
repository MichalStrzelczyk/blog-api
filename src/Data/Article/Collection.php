<?php
declare(strict_types=1);

namespace Data\Article;

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
        if ($clear) {
            $this->clearErrors();
        }
        foreach ($this->data as $element) {
            if (!\Data\Article\Validator::validate($element, $this)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @see \Maleficarum\Data\Collection\Persistable\AbstractCollection::getDomainGroup()
     */
    public function getDomainGroup(): string {
        return 'blog';
    }

    /**
     * @see \Maleficarum\Data\Collection\Persistable\AbstractCollection::getModelPrefix()
     */
    public function getModelPrefix(): string {
        return 'blog';
    }

    /**
     * @see \Maleficarum\Data\Collection\Persistable\AbstractCollection::getStorageGroup()
     */
    public function getStorageGroup(): string {
        return '[blog]articles';
    }

}
