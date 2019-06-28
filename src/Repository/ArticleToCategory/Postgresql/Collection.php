<?php
declare(strict_types=1);

namespace Repository\ArticleToCategory\Postgresql;

/**
 * Class Collection
 *
 * @package Repository\Article\Postgresql
 */
class Collection extends \Maleficarum\Storage\Repository\Postgresql\Collection {
    /**
     * Return shard
     *
     * @param $collection
     *
     * @return \Maleficarum\Storage\Shard\ShardInterface
     */
    public function getShard($collection) {
        return $this->getStorage()->fetchShard('Postgresql', ($this->shardSelector)($collection));
    }


    /**
     * @see \Maleficarum\Storage\Repository\CollectionInterface.deleteAll()
     */
    public function deleteAll(\Maleficarum\Data\Collection\Persistable\AbstractCollection $collection): \Maleficarum\Storage\Repository\CollectionInterface {
        $shard = $this->getShard($collection);

        // Extract entity ids
        $articleIds = [];
        $categoryIds = [];
        foreach ($collection->toArray() as $key => $col_element) {
            isset($col_element['mapArticleCategoryArticleId']) and $articleIds[':_id_token_articleId_'.$key] = $col_element['mapArticleCategoryArticleId'];
            isset($col_element['mapArticleCategoryCategoryId']) and $categoryIds[':_id_token_categoryId_'.$key] = $col_element['mapArticleCategoryCategoryId'];
        }

        // Build the sql query
        $sql = 'DELETE FROM "' . $collection->getStorageGroup() . '" WHERE ';
        $limit = \count($articleIds);
        for ($i=0; $i<$limit; $i++){
            $sql .= '("mapArticleCategoryArticleId" = :_id_token_articleId_'. $i.' AND "mapArticleCategoryCategoryId" = :_id_token_categoryId_'.$i .')';
            if ($i < $limit -1) {
                $sql .= ' OR ';
            }
        }

        // Remove data from the persistence layer
        $statement = $shard->prepare($sql);

        foreach ($articleIds as $k => $v) $statement->bindValue($k, $v);
        foreach ($categoryIds as $k => $v) $statement->bindValue($k, $v);

        $statement->execute();

        return $this;
    }
}