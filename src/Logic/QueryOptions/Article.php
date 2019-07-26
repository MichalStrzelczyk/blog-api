<?php
declare(strict_types=1);

namespace Logic\QueryOptions;

class Article extends \Logic\QueryOptions {
    /**
     * @inhericdoc
     */
    public function populate(array $requestParameters): \Logic\QueryOptionsInterface  {
        if (isset($requestParameters['status'])) {
            $this->filters['articleStatus'] = $requestParameters['status'];
        }

        return parent::populate($requestParameters);
    }

    /**
     * @inhericdoc
     */
    public function validate(): array {
        if (isset($this->filters['articleStatus']) && !\in_array($this->filters['articleStatus'], ['0', '1'])) {
            $this->addError('0001-000104', 'Invalid `sort` parameter - unsupported value. Available values: ' . \implode(',', \array_keys($this->sortMap)));
        }

        return parent::validate();
    }
}