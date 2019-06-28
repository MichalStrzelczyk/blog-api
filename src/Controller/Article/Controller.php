<?php
declare(strict_types=1);

namespace Controller\Article;

/**
 * This controller handles status reporting
 */
class Controller extends \Maleficarum\Api\Controller\Generic {
    use \Maleficarum\Logger\Dependant;
    use \Controller\HttpErrorFormatterTrait;

    /**
     * @var array
     */
    protected static $sortMap = [
        'listAction' => [
            '-status' => [['articleActive', 'DESC']],
            '+status' => [['articleActive', 'ASC']],
            '-date' => [['articleCreatedDate', 'DESC']],
            '+date' => [['articleCreatedDate', 'ASC']],
            '-id' => [['articleId', 'DESC']],
            '+id' => [['articleId', 'ASC']]
        ]
    ];

    /**
     * @var \Logic\Article\Manager
     */
    protected $articleManager;

    /**
     * @param \Logic\Article\Manager $articleCrudManager
     *
     * @return \Controller\Article\Controller
     */
    public function setArticleManager(\Logic\Article\Manager $articleManager): Controller {
        $this->articleManager = $articleManager;

        return $this;
    }

    /**
     * /articles
     *
     * @return \Maleficarum\Response\AbstractResponse
     */
    public function listAction(): \Maleficarum\Response\AbstractResponse {
        // Validation
        $this->validatePagination();
        $this->validateSorting('listAction');

        $sort = $this->getRequest()->sort;
        $status = $this->getRequest()->status;
        $limit = $this->getIntegerParameter('limit');
        $offset = $this->getIntegerParameter('offset');

        // Filters
        $filters = [];
        if (isset($status) && !\in_array((int)$status, [0, 1])) {
            $this->addError('0001-000103', 'Invalid `status` parameter - unsupported value.');
            $this->respondToBadRequest($this->getAllErrors());
        } else{
            $filters['articleActive'] = $status;
        }

        $articles = $this->articleManager->list(
            $limit,
            $offset,
            self::$sortMap['listAction'][$sort],
            $filters
        );

        return $this->getResponse()->render($articles->toArray());
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
