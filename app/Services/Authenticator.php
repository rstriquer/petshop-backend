<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha512;
use Lcobucci\JWT\ValidationData;

class Authenticator
{
    /**
     * @var \Illuminate\Http\Request
     */
    private Request $request;
    /*
     * @var string
     */
    private string $jwtPubSecret;
    /*
     * @var string
     */
    private string $jwtPrivSecret;
    /*
     * @var string
     */
    private string $jwtSecret;

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $jwtSecret
     * @param string $jwtPubSecret
     * @param string $jwtPrivSecret
     */
    public function __construct(Request $request, string $jwtSecret, string $jwtPubSecret = '', string $jwtPrivSecret = '')
    {
        $this->request = request();
        $this->jwtPubSecret = $jwtPubSecret;
        $this->jwtPrivSecret = $jwtPrivSecret;
        $this->jwtSecret = $this->parseKey($jwtSecret);
    }

    /**
     * Method used to generate a new auth (once the user is logged in, of course)
     * @param int $userId
     * @return string
     */
    public function generate(int $userId)
    {
        $signer = new Sha512();

        $token = (new Builder())
            ->setIssuer($this->request->getBaseUrl())
            ->setAudience($this->request->getBaseUrl())
            ->setIssuedAt(time())
            ->setExpiration(time() + 3600)
            ->set('uid', $userId)
            ->sign($signer, $this->jwtSecret)
            ->getToken();
        return base64_encode((string) $token);
    }

    /**
     * @return \App\Models\User|null
     */
    public function validate()
    {
        $token = $this->getTokenForRequest();
        try {
            $parsedToken = (new Parser())->parse((string)@base64_decode($token));
        } catch (\Exception $e) {
            return null;
        }

        if (!$parsedToken->verify(new Sha512(), $this->jwtSecret))
            return null;

        $validationData = new ValidationData();
            $validationData->setIssuer($this->request->getBaseUrl());
            $validationData->setAudience($this->request->getBaseUrl());

        if (!$parsedToken->validate($validationData))
            return null;

        return $this->fetch_user($parsedToken->getClaim('uid'));
    }

    private function getTokenForRequest(): string
    {
        return $this->request->bearerToken();
    }

    private function fetch_user(int $userId): User
    {
        return (new User)->find($userId);
    }

    private function parseKey($jwtSecret)
    {
        if (Str::startsWith($jwtSecret, 'base64:')) {
            $jwtSecret = base64_decode(substr($jwtSecret, 7));
        }
        return $jwtSecret;
    }
}
