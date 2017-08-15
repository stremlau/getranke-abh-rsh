<?php

App::uses('BaseAuthenticate', 'Controller/Component/Auth');


class SimpleBasicAuthenticate extends BaseAuthenticate {

    public $settings = array(
        'user' => 'simple',
        'pass' => 'login',
    );

    /**
     * Constructor, completes configuration for basic authentication.
     *
     * @param ComponentCollection $collection The Component collection used on this request.
     * @param array $settings An array of settings.
     */
    public function __construct(ComponentCollection $collection, $settings) {
        parent::__construct($collection, $settings);
        if (empty($this->settings['realm'])) {
            $this->settings['realm'] = env('SERVER_NAME');
        }
        $this->settings = Hash::merge($this->settings, $settings);
    }

    /**
     * Authenticate a user using HTTP auth. Will use the configured User model and attempt a
     * login using HTTP auth.
     *
     * @param CakeRequest $request The request to authenticate with.
     * @param CakeResponse $response The response to add headers to.
     * @return mixed Either false on failure, or an array of user data on success.
     */
    public function authenticate(CakeRequest $request, CakeResponse $response) {
        return $this->getUser($request);
    }

    /**
     * Get a user based on information in the request. Used by cookie-less auth for stateless clients.
     *
     * @param CakeRequest $request Request object.
     * @return mixed Either false or an array of user information
     */
    public function getUser(CakeRequest $request) {
        $username = env('PHP_AUTH_USER');
        $pass = env('PHP_AUTH_PW');

        if (empty($username) || empty($pass)) {
            return false;
        }

        if ($username == $this->settings['user'] && $pass == $this->settings['pass']) {
            return array('success' => true);
        }

        return false;
    }

    /**
     * Handles an unauthenticated access attempt by sending appropriate login headers
     *
     * @param CakeRequest $request A request object.
     * @param CakeResponse $response A response object.
     * @return void
     * @throws UnauthorizedException
     */
    public function unauthenticated(CakeRequest $request, CakeResponse $response) {
        $Exception = new UnauthorizedException();
        $Exception->responseHeader(array($this->loginHeaders()));
        throw $Exception;
    }

    /**
     * Generate the login headers
     *
     * @return string Headers for logging in.
     */
    public function loginHeaders() {
        return sprintf('WWW-Authenticate: Basic realm="%s"', $this->settings['realm']);
    }

}
