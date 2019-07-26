<?php
declare(strict_types=1);
 
namespace Controller\Status;
 
class StatusController extends \Maleficarum\Api\Controller\Generic {
    /**
     * Returns system status
     *
     * @method: GET
     * @resource: /status
     *
     * @return \Maleficarum\Response\AbstractResponse
     */
    public function getAction(): \Maleficarum\Response\AbstractResponse {
        return $this->getResponse()->render([
            'name' => 'miinto_blog-api',
            'status' => 'OK'
        ]);
    }
}
