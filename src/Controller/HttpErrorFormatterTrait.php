<?php
declare(strict_types=1);

namespace Controller;

/**
 * Trait HttpErrorFormatterTrait
 *
 * @package Controller
 */
trait HttpErrorFormatterTrait {
    /**
     * We log everything what we can for further investigation
     *
     * @param \Exception $e
     */
    protected function addToLog(\Exception $e): void {
        $this->getLogger()->critical($e->errorId . ' ' . $e->getMessage(), [
            'request' => [
                'uri' => $this->request->getUri(),
                'method' => $this->request->getMethod(),
                'headers' => $this->request->getHeaders(),
                'rawData' => $this->request->getRawData(),
            ],
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);
    }
}