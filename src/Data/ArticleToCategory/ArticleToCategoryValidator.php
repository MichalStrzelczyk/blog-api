<?php
declare(strict_types=1);

namespace Data\Article;

class ArticleToCategoryValidator {
    /**
     * ArticleToCategory validation
     *
     * @param array $data
     * @param \Data\Container\ErrorContainerInterface $errorContainer
     */
    public static function validate(array $data,  \Data\Container\ErrorContainerInterface $errorContainer): void {
        if (\is_null($data['articleTitle']) || \strlen($data['articleTitle']) === 0) {
            $errorContainer->addError('0001-000001', 'Article title is empty', 'articleTitle');
        }

        if (\is_null($data['articleRoute']) || \strlen($data['articleRoute']) === 0) {
            $errorContainer->addError('0001-000002', 'Article route is empty', 'articleRoute');
        }
    }
}
