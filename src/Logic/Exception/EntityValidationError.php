<?php


namespace Logic\Exception;


use Throwable;

class EntityValidationError extends \DomainException {

    protected $errorContainer = [];

    public function __construct(array $errorContainer, $message = "", $code = 0, Throwable $previous = null) {
        $this->errorContainer = $errorContainer;

        parent::__construct($message, $code, $previous);
    }

    public function getErrorContainer() {
        return $this->errorContainer;
    }
}