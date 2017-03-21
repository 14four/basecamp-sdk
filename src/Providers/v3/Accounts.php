<?php

namespace FourteenFour\Basecamp\Providers\v3;

// use FourteenFour\Basecamp\Contracts\BasecampsContract;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Accounts {

    private $basecampBaseUrl = 'https://3.basecampapi.com/';

    private $authToken;

    public function __construct( $authToken ) {

        $this->authToken = $authToken;

    }

    public function setToken( $authToken ) {

        $this->authToken = $authToken;

        return this;

    }

    public function all( $page = 0 ) {

        return $this->request("/authorization.json");

    }

    // public function find( $id ) {
    //
    // }
    //
    // public function create( $data ) {
    //
    // }
    //
    // public function update( $id, $data ) {
    //
    // }
    //
    // public function delete( $id ) {
    //
    // }

    private function request( $path, $method = 'GET') {

        $client = new Client();

        $request = new Request($method, 'https://launchpad.37signals.com' . $path, [
            'Authorization' => "Bearer $this->authToken",
            'Content-Type' => 'application/json',
        ], null, '1.1');
        //
        $response = $client->send($request);

        return json_decode($response->getBody());

    }

    private function checkResponse( $response ) {

        if ( $response->getStatusCode() != 200 ) {
            return false;
        }

        return true;

    }

}
