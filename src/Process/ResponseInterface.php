<?php
declare(strict_types=1);

namespace Process;

interface ResponseInterface {

    public function getStatus(): bool;

    public function getData(): array;
}