<?php

namespace FourteenFour\Basecamp\Factories;

use GuzzleHttp\Client;

class RequestFactory {

    public static function create( $application ) {

        return new Client([
            'base_uri' => 'https://3.basecampapi.com/',
            'headers' => [
                'User-Agent' => $application,
                'Content-Type' => 'application/json',
            ]
        ]);

    }


}
