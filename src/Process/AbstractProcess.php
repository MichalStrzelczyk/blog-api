<?php
declare(strict_types=1);

namespace Process;

abstract class AbstractProcess {
    /** @var ResponseInterface */
    protected $processResponse;

    /**
     * AbstractProcess constructor.
     *
     * @param ResponseInterface $processResponse
     */
    public function __construct(ResponseInterface $processResponse) {
        $this->processResponse = $processResponse;
    }

    /**
     * @param array $options
     *
     * @return mixed
     */
    abstract protected function validate(array $options = []);

    /**
     * @param array $options
     *
     * @return mixed
     */
    abstract protected function execute(array $options = []);

    /**
     * @param array $options
     *
     * @return ResponseInterface
     */
    final public function handle(array $options = []): ResponseInterface {
        $this->validate($options);
        if (!$this->getResponse()->getStatus()) {
            throw new \Process\Exception\ValidationError($this->getResponse()->getAllErrors());
        }

        $this->execute($options);

        return $this->getResponse();
    }

    /**
     * @return ResponseInterface
     */
    protected function getResponse(): ResponseInterface {
        return $this->processResponse;
    }
}