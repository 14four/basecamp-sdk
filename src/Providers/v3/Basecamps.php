<?php

namespace FourteenFour\Basecamp\Providers\v3;

use FourteenFour\Basecamp\Contracts\BasecampsContract;
use GuzzleHttp\Client;

class Basecamps implements BasecampsContract {

    private $basecampBaseUrl = 'https://3.basecampapi.com/';

    private $accountId;

    private $authToken;

    public function __construct( $authToken, $accountId, Client $client ) {

        $this->authToken = $authToken;

        $this->accountId = $accountId;

        $this->client = $client;

    }

    public function setAccount( $accountId ) {

        $this->accountId = $accountId;

        return $this;

    }

    public function setToken( $authToken ) {

        $this->authToken = $authToken;

        return $this;

    }

    public function page( $page = 0 ) {

        return $this->request("/projects.json?page=$page");

    }

    public function find( $id ) {

        return $this->request("/projects/$id.json");

    }

    public function create( $data ) {

    }

    public function update( $id, $data ) {

    }

    public function delete( $id ) {

    }

    private function getHeaders() {

        return [
            'headers' => [
                'Authorization' => "Bearer $this->authToken",
            ]
        ];

    }

    private function request( $path, $method = 'GET', $body = '' ) {

        $response = $this->client->request($method, $this->accountId . $path, $this->getHeaders());

        if ( !$this->checkResponse( $response ) ) {
            throw new \Exception('Bad Response from Basecamp');
        }

        return json_decode($response->getBody());

    }

    private function checkResponse( $response ) {

        if ( $response->getStatusCode() != 200 ) {
            return false;
        }

        return true;

    }

}
