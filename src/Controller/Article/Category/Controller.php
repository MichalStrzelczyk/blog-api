<?php
declare(strict_types=1);

namespace Controller\Article\Category;

/**
 * This controller handles status reporting
 */
class Controller extends \Maleficarum\Api\Controller\Generic {
    use \Maleficarum\Logger\Dependant;
    use \Controller\HttpErrorFormatterTrait;

    /**
     * @var \Logic\Article\ArticleManager
     */
    protected $articleManager;

    /**
     * @param \Logic\Article\ArticleManager $articleCrudManager
     *
     * @return \Controller\Article\Controller
     */
    public function setArticleManager(\Logic\Article\ArticleManager $articleManager): Controller {
        $this->articleManager = $articleManager;

        return $this;
    }

    /**
     * /article/{articleId}/categories
     *
     * @return \Maleficarum\Response\AbstractResponse
     *
     * @throws \Maleficarum\Storage\Exception\Repository\EntityNotFoundException
     */
    public function assignAction(): \Maleficarum\Response\AbstractResponse {
        $articleId = $this->getIntegerParameter('articleId');
        $categoryIds = $this->getRequest()->getRawData()['categoryIds'];

        $this->articleManager->assignToCategories($articleId, $categoryIds);

        return $this->getResponse()->render([
            'statusMessage' => 'Article was successfully assigned to categories'
        ]);
    }

    /**
     * @param string $method
     *
     * @return bool|mixed
     */
    public function __remap(string $method) {
        try {
            $action = $method . 'Action';

            /**
             * Checking ACL code here
             *
             * throw \Maleficarum\Exception\UnauthorizedException when user doesn't have access to action
             */
            if (\method_exists($this, $action)) {
                $this->{$action}();
            } else {
                $this->respondToNotFound('404 - page not found.');
            }
        } catch (\Maleficarum\Storage\Exception\Repository\EntityNotFoundException $e) {
            $this->respondToNotFound($e->getMessage());
        } catch (\Maleficarum\Exception\HttpException $e) {
            throw $e;
        } catch (\Exception $e) {
            // Unexpected error
            $e->errorId = \uniqid('E');
            $this->addToLog($e);

            throw new \Maleficarum\Exception\HttpException(500, 'Generic error - please check logfile for more information. Error nr: ' . $e->errorId);
        }

        return true;
    }
}
