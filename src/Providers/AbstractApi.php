<?php

namespace FourteenFour\Basecamp\Providers;

use FourteenFour\Basecamp\Exceptions\BasecampError;
use FourteenFour\Basecamp\Exceptions\RateLimitError;
use GuzzleHttp\Client;

abstract class AbstractApi {

    public $options = [
        'accountId' => '',
    ];

    public $headers;

    public function __construct( $options = [], Client $client ) {

        $this->setOptions( $options );

        $this->client = $client;

    }

    public function __set( $name, $value ) {

        $this->options[$name] = $value;

    }

    public function __get( $name ) {

        if ( $name == 'headers' ) {
            return $this->headers;
        }

        return $this->options[$name];

    }

    public function setOptions( $options ) {

        foreach( $options as $key => $value ) {
            $this->options[$key] = $value;
        }

        return $this;

    }

    public function setOption( $name, $value ) {

        $this->options[$name] = $value;

        return $this;

    }

    public function getHeaders() {

        return $this->headers;

    }

    public function getHeader( $header ) {

        return $this->headers[$header][0];

    }

    public function get($path = '', $data = []) {

        return $this->request('GET', $path, $data);

    }

    public function post($path = '', $data = []) {

        return $this->request('POST', $path, $data);

    }

    public function put($path = '', $data = []) {

        return $this->request('PUT', $path, $data);

    }

    public function delete($path = '') {

        return $this->request('DELETE', $path);

    }

    private function requestHeaders() {

        $headers = [];

        $headers['Authorization'] = "Bearer " . $this->options['authToken'];

        if ( !empty($this->options['etag']) ) {
            $headers['If-None-Match'] = $this->options['etag'];
        }

        if ( !empty($this->options['lastModified']) ) {
            $headers['If-Modified-Since'] = $this->options['lastModified'];
        }

        return $headers;

    }

    public function request( $method, $path, $params = [] ) {

        $urlParams = '';

        if ( $method == 'GET' && count($params) >= 1 ) {
            $urlParams = $this->getParams( $params, $path );
        }

        try {
            $response = $this->client->request($method, $this->options['accountId'] . $path . $urlParams, [
                'headers' => $this->requestHeaders(),
                'json' => $params,
            ]);
        } catch (\Exception $e) {
            $response = $e->getCode();
            switch ($e->getCode()) {
                case 429:
                    throw new RateLimitError($response, $e->getMessage());
                    break;

                default:
                    throw new BasecampError($response, $e->getMessage());
                    break;
            }
        }

        $this->setHeaders( $response );
        $this->checkResponse( $response );

        return json_decode( $response->getBody() );

    }


    private function getParams( $params, $path ) {

        $getParams = strpos('?', $path) ? '?' : '&';
        $first = true;

        foreach( $params as $key => $value ) {

            $getParams .= ($first ? '' : '&') .  "$key=$value";

            $first = false;
        }

        return $getParams;

    }


    private function setHeaders( $response ) {

        $this->headers = $response->getHeaders();

    }


    private function checkResponse( $response ) {

        // TODO: CHECK FOR 507 Insufficient Storage
        //

        return true;

    }

}
