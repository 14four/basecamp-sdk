<?php

namespace FourteenFour\Basecamp\Providers;

use FourteenFour\Basecamp\Contracts\BasecampsContract;

class Basecamps extends AbstractApi implements BasecampsContract {

    public function all( $status = '' ) {

        // TODO: loop over pages and return a single object with all
        $data = [];
        $page = 0;
        $total = 1;

        while ( count($data) < $total ) {

            $response = $this->page( $page, $status );

            $total = (int)$this->headers['X-Total-Count'][0];

            $data = array_merge($data, $response);

            $page++;

        }

        return $data;

    }

    public function page( $page = 0, $status = '' ) {

        return $this->get( "/projects.json?page=$page", ['status' => $status]);

    }

    public function archived() {

        return $this->all( 'archived' );

    }

    public function trashed() {

        return $this->all( 'trashed' );

    }

    public function find( $id ) {

        return $this->get( "/projects/$id.json");

    }

    public function create( $data ) {

        // TODO: VALIDATE name IS REQUIRED
        // TODO: VALIDATE description IS STRING

        return $this->post( '/projects.json', $data);

    }

    public function update( $id, $data ) {

        // TODO: VALIDATE name IS REQUIRED
        // TODO: VALIDATE description IS STRING

        return $this->put( "/projects/$id.json", $data);

    }

    public function trash( $id ) {

        $this->delete( "/projects/$id.json");

    }

}
