<?php

declare(strict_types=1);

namespace Verdient\PoleShip;

use Verdient\http\Response as HttpResponse;
use Verdient\HttpAPI\AbstractResponse;
use Verdient\HttpAPI\Result;

/**
 * 响应
 * @author Verdient。
 */
class Response extends AbstractResponse
{
    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function normailze(HttpResponse $response): Result
    {
        $result = new Result();
        $statusCode =  $response->getStatusCode();
        $body = $response->getBody();
        if ($statusCode === 200) {
            if (isset($body['statusCode']) && $body['statusCode'] == 'success') {
                if (isset($body['returnDatas'])) {
                    if (isset($body['returnDatas'][0]['statusCode']) && $body['returnDatas'][0]['statusCode'] == 'success') {
                        $result->isOK = true;
                        $result->data = $body;
                    } else {
                        $result->isOK = false;
                        $result->data = $body;
                    }
                } else {
                    $result->isOK = true;
                    $result->data = $body;
                }
            } else {
                $result->isOK = false;
                $result->data = $body;
            }
        }
        if (!$result->isOK) {
            $result->errorCode = $statusCode;
            $result->errorMessage = $body['returnDatas'][0]['message'] ?? $response->getStatusMessage();

            if (isset($body['message'])) {
                $result->errorMessage = $body['message'] ?? $response->getStatusMessage();
            }
        }
        return $result;
    }
}
