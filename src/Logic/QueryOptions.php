<?php
declare(strict_types=1);

namespace Logic;

class QueryOptions implements QueryOptionsInterface {
    use \Maleficarum\Data\Container\Error\Container;

    /** @var array */
    protected $sortMap = [];

    /** @var int */
    protected $limit = 10;

    /** @var int */
    protected $maxLimit = 100;

    /** @var int */
    protected $offset = 0;

    /** @var string */
    protected $sort;

    /** @var array */
    protected $filters = [];

    /**
     * QueryOptions constructor.
     *
     * @param int $limit
     * @param int $maxLimit
     * @param int $offset
     * @param string|null $sort
     * @param array $sortMap
     * @param array $filters
     */
    public function __construct(int $limit = 10, int $maxLimit = 100, int $offset = 0, string $sort = null, array $sortMap = [], array $filters = []) {
        $this->limit = $limit;
        $this->maxLimit = $maxLimit;
        $this->offset = $offset;
        $this->sort = $sort;
        $this->sortMap = $sortMap;
        $this->filters = $filters;
    }

    /**
     * @return int
     */
    public function getLimit(): int {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset(): int {
        return $this->offset;
    }

    /**
     * @return array
     */
    public function getSorting(): array {
        if (isset($this->sortMap[$this->sort])) {
            return $this->sortMap[$this->sort];
        }

        return [];
    }

    /**
     * @return array
     */
    public function getFilters(): array {
        return $this->filters;
    }

    /**
     * @param array $requestParameters
     *
     * @return $this
     */
    public function populate(array $requestParameters): \Logic\QueryOptionsInterface {
        if (isset($requestParameters['limit'])) {
            $this->limit = (int) $requestParameters['limit'];
        }

        if (isset($requestParameters['offset'])) {
            $this->offset = (int) $requestParameters['offset'];
        }

        if (isset($requestParameters['sort'])) {
            $this->sort = $requestParameters['sort'];
        }

        if (isset($requestParameters['filters'])) {
            $this->filters = $requestParameters['filters'];
        }

        return $this;
    }

    /**
     * @return array
     */
    public function validate(): array {
        if ($this->getLimit() < 0 || $this->getLimit() > $this->maxLimit) {
            $this->addError('0001-000101', 'Invalid `limit` parameter - unsupported value.');
        }

        if ($this->getOffset() < 0) {
            $this->addError('0001-000102', 'Invalid `offset` parameter - unsupported value.');
        }

        if (!\key_exists($this->sort, $this->sortMap)) {
            $this->addError('0001-000103', 'Invalid `sort` parameter - unsupported value. Available values: '.  \implode(',', \array_keys($this->sortMap)));
        }

        return $this->getErrors();
    }
}