<?php

declare(strict_types=1);

namespace Verdient\PoleShip;

use Verdient\http\Request as HttpRequest;

/**
 * 请求
 * @author Verdient。
 */
class Request extends HttpRequest
{
    /**
     * 客户端编号
     * @author Verdient。
     */
    public string $clientId = '';

    /**
     * 访问秘钥
     * @author Verdient。
     */
    public string $token = '';

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function send(): Response
    {
        $this->addBody('Verify', [
            'Clientid' => $this->clientId,
            'Token' => $this->token
        ]);
        return new Response(parent::send());
    }
}
