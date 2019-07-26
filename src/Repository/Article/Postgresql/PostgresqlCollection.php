<?php
declare(strict_types=1);

namespace Repository\Article\Postgresql;

class PostgresqlCollection extends \Maleficarum\Storage\Repository\Postgresql\Collection {
    /**
     * @see \Maleficarum\Storage\Repository\Postgresql\Collection::getSortColumns()
     */
    protected function getSortColumns(): array {
        return ['articleId', 'articleStatus', 'articleCreatedDate'];
    }
}