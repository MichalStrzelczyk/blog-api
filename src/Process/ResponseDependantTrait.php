<?php
declare(strict_types=1);

namespace Process;

trait ResponseDependantTrait {
    /** @var \Process\Response */
    protected $response;

    /**
     * @return Response
     */
    public function getResponse(): \Process\Response {
        return $this->response;
    }

    /**
     * @param Response $response
     *
     * @return ResponseDependantTrait
     */
    public function setResponse(\Process\Response $response): self {
        $this->response = $response;

        return $this;
    }
}