<?php

namespace App\Auth;

use App\Models\User;
use BadMethodCallException;
use Exception;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Traits\Macroable;
use Tymon\JWTAuth\JWT;
use Illuminate\Http\Request;


class KeycloakGuard implements Guard
{

    use GuardHelpers, Macroable {
        __call as macroCall;
    }

    private $jwt;
    private $request;

    public function __construct(JWT $jwt, Request $request)
    {
        $this->jwt = $jwt;
        $this->request = $request;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if ($this->user !== null) {
            return $this->user;
        }

        if (
            $token = $this->jwt->setRequest($this->request)->getToken() &&
            ($payload = $this->jwt->check(true)) &&
            $this->validateSubject()
        ) {
            return $this->user = new User($payload['sub'], $payload['name'], $payload['email'], $token);
        }
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     *
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        throw new Exception('Not Implemented');
    }


    /**
     * Magically call the JWT instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     *
     * @throws \BadMethodCallException
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->jwt, $method)) {
            return call_user_func_array([$this->jwt, $method], $parameters);
        }

        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        throw new BadMethodCallException("Method [$method] does not exist.");
    }
}
