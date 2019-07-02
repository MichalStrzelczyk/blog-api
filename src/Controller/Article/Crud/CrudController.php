<?php
declare(strict_types=1);

namespace Controller\Article\Crud;

class CrudController extends \Maleficarum\Api\Controller\Generic {
    use \Maleficarum\Logger\Dependant;
    use \Controller\HttpErrorFormatterTrait;

    /** @var \Logic\Article\Crud\CrudManager  */
    protected $articleCrudManager;

    /**
     * @param \Logic\Article\Crud\CrudManager $articleCrudManager
     * s
     * @return CrudController
     */
    public function setArticleCrudManager(\Logic\Article\Crud\CrudManager $articleCrudManager): CrudController {
        $this->articleCrudManager = $articleCrudManager;

        return $this;
    }

    /**
     * /articles
     *
     * @return \Maleficarum\Response\AbstractResponse
     */
    public function createAction(): \Maleficarum\Response\AbstractResponse {
        $article = $this->articleCrudManager->create($this->request->getParameters($this->request::METHOD_POST));

        // Everything is correct
        return $this->getResponse()->setStatusCode(201)->render([
            $article->getDTO()
        ]);
    }

    /**
     * /articles/{articleId}
     *
     * @return \Maleficarum\Response\AbstractResponse
     *
     * @throws \Maleficarum\Storage\Exception\Repository\EntityNotFoundException
     */
    public function readAction(): \Maleficarum\Response\AbstractResponse {
        $articleId = $this->getIntegerParameter('articleId');
        $article = $this->articleCrudManager->read($articleId);

        return $this->getResponse()->render($article->getDTO());
    }

    /**
     * /articles/{articleId}
     *
     * @return \Maleficarum\Response\AbstractResponse
     *
     * @throws \Maleficarum\Storage\Exception\Repository\EntityNotFoundException
     */
    public function updateAction(): \Maleficarum\Response\AbstractResponse {
        $articleId = $this->getIntegerParameter('articleId');
        $data = $this->getRequest()->getRawData();
        $article = $this->articleCrudManager->update($articleId, $data);

        return $this->getResponse()->render($article->getDTO());
    }

    /**
     * /articles/{articleId}
     *
     * @return \Maleficarum\Response\AbstractResponse
     *
     * @throws \Maleficarum\Storage\Exception\Repository\EntityNotFoundException
     */
    public function deleteAction(): \Maleficarum\Response\AbstractResponse {
        $articleId = $this->getIntegerParameter('articleId');
        $this->articleCrudManager->delete($articleId);

        return $this->getResponse()->render([
            'statusMessage' => 'Article was successfully deleted'
        ]);
    }

    /**
     * @param string $method
     *
     * @return bool|mixed
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
        } catch (\Logic\Exception\EntityValidationError $e) {
            $this->respondToBadRequest($e->getErrorContainer());
        } catch (\Maleficarum\Exception\HttpException $e) {
            throw $e;
        } catch (\Exception $e) {
            // Unexpected error
            $e->errorId = \uniqid('E');
            $this->addToLog($e);

            throw new \Maleficarum\Exception\HttpException(500, 'Generic error - please check logfile for more information. Error nr: '. $e->errorId);
        }
    }
}
