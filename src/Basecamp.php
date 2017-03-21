<?php

namespace FourteenFour\Basecamp;



class Basecamp {

    private $token;

    public function __construct( $token = null ) {

        $this->token = $token;

    }

    public function basecamps( $token = null ) {

        if ( $token ) {

        }

        return new Basecamps( $this->token );

    }

}
