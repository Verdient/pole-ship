<?php

declare(strict_types=1);

namespace Verdient\PoleShip;

use Verdient\HttpAPI\AbstractClient;

/**
 * 极运
 * @author Verdient。
 */
class PoleShip extends AbstractClient
{
    /**
     * 客户端编号
     * @author Verdient。
     */
    protected string $clientId = '';

    /**
     * 访问秘钥
     * @author Verdient。
     */
    protected string $token = '';

    /**
     * 代理主机
     * @author Verdient。
     */
    protected string|null $proxyHost = null;

    /**
     * 代理端口
     * @author Verdient。
     */
    protected int|string|null $proxyPort = null;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public $request = Request::class;

    /**
     * 请求
     * @author Verdient。
     */
    public function request($method): Request
    {
        $class = $this->request ?: Request::class;
        $request = new $class;
        $request->setUrl($this->getRequestPath() . '/PostInterfaceService');
        $request->setMethod('POST');
        $request->addQuery('method', $method);
        if ($this->proxyHost) {
            $request->setProxy($this->proxyHost, empty($this->proxyPort) ? null : intval($this->proxyPort));
        }
        $request->clientId = $this->clientId;
        $request->token = $this->token;
        return $request;
    }
}
