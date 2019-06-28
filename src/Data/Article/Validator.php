<?php

declare(strict_types=1);

namespace Data\Article;

class Validator {
    /**
     * Article validation
     *
     * @param array $data
     * @param \Maleficarum\Data\Container\Error\Container $errorContainer
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public static function validate(array $data,  $errorContainer): bool {
        if (\is_null($data['articleTitle']) || \strlen($data['articleTitle']) === 0) {
            $errorContainer->addError('9999-000001', 'Article title is empty', 'articleTitle');
        }

        if (\is_null($data['articleRoute']) || \strlen($data['articleRoute']) === 0) {
            $errorContainer->addError('9999-000002', 'Article route is empty', 'articleRoute');
        }

        return !$errorContainer->hasErrors();
    }
}
