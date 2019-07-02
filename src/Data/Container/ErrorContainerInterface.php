<?php
declare (strict_types=1);

namespace Data\Container;

interface ErrorContainerInterface {

    public function clearErrors();

    public function getErrors(string $namespace = '__default_error_namespace__'): array;

    public function getAllErrors();

    public function hasErrors(string $namespace = '__default_error_namespace__'): bool;
}
