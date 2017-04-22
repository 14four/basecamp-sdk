<?php

namespace FourteenFour\Basecamp\Providers;

use FourteenFour\Basecamp\Traits\RecordingsTrait;
use FourteenFour\Basecamp\Contracts\BasecampsContract;

class People extends AbstractApi implements BasecampsContract {

    public function setBasecamp( $basecampId ) {

        $this->options['basecamp'] = $basecampId;

        return $this;

    }

    public function getBasecamp() {

        return $this->options['basecamp'];

    }

    public function setPeople( $peopleId ) {

        $this->options['people'] = $peopleId;

        return $this;

    }

    public function getPeople() {

        return $this->options['people'];

    }

    public function all( $status = null ) {

        // TODO: loop over pages and return a single object with all
        $data = [];
        $page = 0;
        $total = 1;

        while ( count($data) < $total ) {

            $response = $this->page( $page );

            $total = (int)$this->headers['X-Total-Count'][0];

            $data = array_merge($data, $response);

            $page++;

        }

        return $data;

    }

    public function archived() {

        return $this->all();

    }

    public function trashed() {

        return $this->all();

    }

    public function page( $page = 0, $status = null ) {

        return $this->get( "/people.json?page=$page" );

    }

    public function find( $id ) {

        return $this->get('/buckets/' . $this->options['basecamp'] . "/todolists/$id.json");

    }

    public function create( $data ) {

        // TODO: VALIDATE name IS REQUIRED
        // TODO: VALIDATE description IS STRING

        return $this->post('/buckets/' . $this->options['basecamp'] . "/todosets/$this->todoSet/todolists.json", $data);

    }

    public function update( $id, $data ) {

        // TODO: VALIDATE name IS REQUIRED
        // TODO: VALIDATE description IS STRING

        return $this->put('/buckets/' . $this->options['basecamp'] . "/todosets/$this->todoSet/todolists/$id.json", $data);

    }

    public function trash( $id ) {

        $this->delete("/projects/$id.json");

    }

}
