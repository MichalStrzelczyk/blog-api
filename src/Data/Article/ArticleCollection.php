<?php
declare(strict_types=1);

namespace Data\Article;

class ArticleCollection extends \Maleficarum\Data\Collection\Persistable\AbstractCollection {
    use \Maleficarum\Data\Container\Error\Container;

    /**
     * @see \Maleficarum\Data\Collection\Persistable\AbstractCollection::validate()
     */
    public function validate(bool $clear = true): bool {
        $this->clearErrors();

        foreach ($this->data as $element) {
            \Data\Article\ArticleValidator::validate($element, $this);
            if($this->hasErrors()){
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
