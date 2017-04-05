<?php

namespace FourteenFour\Basecamp;

use FourteenFour\Basecamp\Factories\RequestFactory;
use FourteenFour\Basecamp\Providers\User;
use FourteenFour\Basecamp\Providers\Basecamps;
use FourteenFour\Basecamp\Providers\People;
use GuzzleHttp\Client;

class Basecamp {

    private $options;

    private $client;

    public function __construct( $application, $options = [] ) {

        $this->setOptions( $options );

        $this->client = RequestFactory::create( $application );

    }

    public function setOptions( $options ) {

        foreach( $options as $key => $value ) {
            $this->options[$key] = $value;
        }

    }

    public function setOption($name, $value) {

        $this->options[$name] = $value;

    }

    public function __set($name, $value) {

        $this->options[$name] = $value;

    }

    public function __get($name) {

        return $this->options[$name];

    }

    public function user( $authToken = null ) {

        $options = $this->options;

        if ( !is_null($authToken) ) {
            $options['authToken'] = $authToken;
        }

        return new User( $options, $this->client );

    }

    public function basecamps( $authToken = null, $accountId = null ) {

        $options = $this->options;

        if ( !is_null($authToken) ) {
            $options['authToken'] = $authToken;
        }

        if ( !is_null($accountId) ) {
            $options['accountId'] = $accountId;
        }

        return new Basecamps( $options, $this->client );

    }

    public function people( $authToken = null, $accountId = null, $basecampId = null ) {

        $options = $this->options;

        if ( !is_null($authToken) ) {
            $options['authToken'] = $authToken;
        }

        if ( !is_null($accountId) ) {
            $options['accountId'] = $accountId;
        }

        if ( !is_null($basecampId) ) {
            $options['basecamp'] = $basecampId;
        }

        return new People( $options, $this->client );

    }

}
