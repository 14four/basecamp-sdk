<?php
namespace FourteenFour\Basecamp\Exceptions;

use Exception;

class RateLimitError extends Exception {

    protected $response;

    public function __construct($response, $message = '', $code = 0, Exception $previous = null) {
        $this->response = $response;

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    public function getResponse() {
        return $this->response;
    }
}
