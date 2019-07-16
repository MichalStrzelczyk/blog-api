<?php
declare(strict_types=1);

namespace Controller\Article;

class ArticleController extends \Maleficarum\Api\Controller\Generic {
    use \Maleficarum\Logger\Dependant;
    use \Controller\HttpErrorFormatterTrait;

    /** @var \Logic\QueryOptions */
    protected $queryOptions;

    /**
     * @param \Logic\QueryOptions $queryOptions
     *
     * @return ArticleController
     */
    public function setQueryOptions(\Logic\QueryOptions $queryOptions): ArticleController {
        $this->queryOptions = $queryOptions;

        return $this;
    }

    /**
     * /articles
     *
     * @return \Maleficarum\Response\AbstractResponse
     */
    public function listAction(): \Maleficarum\Response\AbstractResponse {
        $this->queryOptions->populate($this->getRequest()->getParameters());
        $errors = $this->queryOptions->validate();
        if(\count($errors) > 0) {
            throw new \Process\Exception\ValidationError($errors);
        }

        $process = \Maleficarum\Ioc\Container::get(\Process\Article\ReadAll::class);
        $response = $process->handle(['queryOptions' => $this->queryOptions]);

        return $this->getResponse()->render($response->getData());
    }

    /**
     * @param string $method
     */
    public function __remap(string $method): void {
        try {
            $action = $method . 'Action';

            /**
             * Checking ACL
             * throw \Maleficarum\Exception\UnauthorizedException when user doesn't have access to action
             */
            if (\method_exists($this, $action)) {
                $this->{$action}();
            } else {
                $this->respondToNotFound('404 - page not found.');
            }
        } catch (\Maleficarum\Storage\Exception\Repository\EntityNotFoundException $e) {
            $this->respondToNotFound($e->getMessage());
        } catch (\Process\Exception\ValidationError $e) {
            $this->respondToBadRequest($e->getErrorContainer());
        } catch (\Maleficarum\Exception\HttpException $e) {
            throw $e;
        } catch (\Exception $e) {
            // Unexpected error
            $e->errorId = \uniqid('E');
            $this->addToLog($e);

            throw new \Maleficarum\Exception\HttpException(500, 'Generic error - please check logfile for more information. Error nr: ' . $e->errorId);
        }
    }
}
