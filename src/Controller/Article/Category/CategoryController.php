<?php
declare(strict_types=1);

namespace Controller\Article\Category;

class CategoryController extends \Maleficarum\Api\Controller\Generic {
    use \Maleficarum\Logger\Dependant;
    use \Controller\HttpErrorFormatterTrait;

    /**
     * /article/{articleId}/categories
     *
     * @throws \Maleficarum\Storage\Exception\Repository\EntityNotFoundException
     *
     * @return \Maleficarum\Response\AbstractResponse
     */
    public function attachAction(): \Maleficarum\Response\AbstractResponse {
        $articleId = $this->getIntegerParameter('articleId');
        $categoryIds = $this->getRequest()->getRawData()['categoryIds'];

        $process = \Maleficarum\Ioc\Container::get(\Process\Article\AttachToCategories::class);
        $process->handle([
            'articleId' => $articleId,
            'categoryIds' => $categoryIds
        ]);

        return $this->getResponse()->render([
            'statusMessage' => 'Article was successfully assigned to categories'
        ]);
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
