<?php

namespace FourteenFour\Basecamp\Providers;

use FourteenFour\Basecamp\Traits\RecordingsTrait;
use FourteenFour\Basecamp\Contracts\BasecampsContract;
use FourteenFour\Basecamp\Contracts\RecordingsConract;

class TodoLists extends AbstractApi implements BasecampsContract, RecordingsConract {

    public function setBasecamp( $basecampId ) {

        $this->otpions['basecamp'] = $basecampId;

        return $this;

    }

    public function getBasecamp() {

        return $this->otpions['basecamp'];

    }

    public function setTodoset( $todoSetId ) {

        $this->otpions['todoSet'] = $todoSetId;

        return $this;

    }

    public function getTodoset() {

        return $this->otpions['todoSet'];

    }

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

        return $this->get('/buckets/' . $this->otpions['basecamp'] . "/todosets/$this->todoSet/todolists.json?page=$page", ['status' => $status]);

    }

    public function archived() {

        return $this->all( 'archived' );

    }

    public function trashed() {

        return $this->all( 'trashed' );

    }

    public function find( $id ) {

        return $this->get('/buckets/' . $this->otpions['basecamp'] . "/todolists/$id.json");

    }

    public function create( $data ) {

        // TODO: VALIDATE name IS REQUIRED
        // TODO: VALIDATE description IS STRING

        return $this->post('/buckets/' . $this->otpions['basecamp'] . "/todosets/$this->todoSet/todolists.json", $data);

    }

    public function update( $id, $data ) {

        // TODO: VALIDATE name IS REQUIRED
        // TODO: VALIDATE description IS STRING

        return $this->put('/buckets/' . $this->otpions['basecamp'] . "/todosets/$this->todoSet/todolists/$id.json", $data);

    }

    public function trash( $id ) {

        $this->delete("/projects/$id.json");

    }

}
