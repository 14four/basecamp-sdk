<?php

namespace FourteenFour\Basecamp;

use FourteenFour\Basecamp\Factories\RequestFactory;
use FourteenFour\Basecamp\Providers\v3\Basecamps;
use GuzzleHttp\Client;

class Basecamp {

    private $authToken;

    private $accountId;

    private $client;

    public function __construct( $application = '', $authToken = null, $accountId = null ) {

        $this->application = $application;

        $this->authToken = $authToken;

        $this->accountId = $accountId;

        $this->client = RequestFactory::create( $application );

    }

    public function setAccount( $accountId ) {

        $this->accountId = $accountId;

        return $this;

    }

    public function setToken( $authToken ) {

        $this->tauthTken = $authToken;

        return $this;

    }

    public function basecamps( $authToken = null ) {

        if ( $authToken ) {
            $this->authToken = $authToken;
        }

        return new Basecamps( $this->authToken, $this->accountId, $this->client );

    }

}
