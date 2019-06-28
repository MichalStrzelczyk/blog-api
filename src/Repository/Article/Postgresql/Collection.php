<?php
declare(strict_types=1);

namespace Repository\Article\Postgresql;

/**
 * Class Collection
 *
 * @package Repository\Article\Postgresql
 */
class Collection extends \Maleficarum\Storage\Repository\Postgresql\Collection {
    /**
     * @see \Maleficarum\Storage\Repository\Postgresql\Collection::getSortColumns()
     */
    protected function getSortColumns(): array {
        return ['articleId', 'articleStatus', 'articleCreatedDate'];
    }
}