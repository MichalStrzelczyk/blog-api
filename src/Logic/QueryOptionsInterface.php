<?php
declare(strict_types=1);

namespace Logic;

interface QueryOptionsInterface {

    /**
     * @return int
     */
    public function getLimit(): int;

    /**
     * @return int
     */
    public function getOffset(): int;

    /**
     * @return array
     */
    public function getSorting(): array;

    /**
     * @return array
     */
    public function getFilters(): array;
}