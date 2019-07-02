<?php
declare(strict_types=1);

namespace Logic\Exception;

class EntityValidationError extends \DomainException {

    /**
     * Error container
     *
     * @var array
     */
    protected $errorContainer = [];

    /**
     * EntityValidationError constructor.
     *
     * @param array $errorContainer
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(array $errorContainer, $message = "", $code = 0, \Throwable $previous = null) {
        $this->errorContainer = $errorContainer;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getErrorContainer(): array {
        return $this->errorContainer;
    }
}