<?php

namespace FourteenFour\Basecamp\Providers\v3;

use FourteenFour\Basecamp\Contracts\BasecampsContract;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Basecamps implements BasecampsContract {

    private $basecampBaseUrl = 'https://3.basecampapi.com/';

    private $accountId;

    private $authToken;

    public function __construct( $authToken, $accountId ) {

        $this->authToken = $authToken;

        $this->accountId = $accountId;

    }

    public function setAccount( $accountId ) {

        $this->accountId = $accountId;

        return this;

    }

    public function setToken( $authToken ) {

        $this->authToken = $authToken;

        return this;

    }

    public function page( $page = 0 ) {

        return $this->request("/projects.json");

    }

    public function find( $id ) {

    }

    public function create( $data ) {

    }

    public function update( $id, $data ) {

    }

    public function delete( $id ) {

    }

    private function request( $path, $method = 'GET', $body = '' ) {

        $client = new Client();

        // $request = new Request($method, 'https://3.basecampapi.com/' . $this->accountId . $path, [
        //     'Authorization' => "Bearer $this->authToken"
        // ], json_encode($body), '1.1');
        //
        // $response = $client->send($request, ['verify' => false]);

        $request = $client->request($method, 'https://3.basecampapi.com/' . $this->accountId . $path, ['verify' => true, 'debug' => true, 'curl' => [CURLOPT_SSL_VERIFYHOST => 2]]);

        return json_decode($response->getBody());

        // if ( !$this->checkResponse( $response ) ) {
        //     // throw error
        // }

        return json_decode($response->getBody());

    }

    private function checkResponse( $response ) {

        if ( $response->getStatusCode() != 200 ) {
            return false;
        }

        return true;

    }

}
