<?php
declare(strict_types=1);

namespace Process;

class Response implements ResponseInterface {
    use \Maleficarum\Data\Container\Error\Container;

    /** @var array  */
    protected $data = [];

    /**
     * @return bool
     */
    public function getStatus(): bool {
        return !$this->hasErrors();
    }

    /**
     * @return array
     */
    public function getData(): array {
        return $this->data;
    }

    /**
     * @param array $data
     *
     * @return Response
     */
    public function setData(array $data): Response {
        $this->data = $data;

        return $this;
    }
}