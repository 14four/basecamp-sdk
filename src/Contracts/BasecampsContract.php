<?php

namespace FourteenFour\Basecamp\Contracts;

interface BasecampsContract {

    public function setToken( $token );

    public function page();

    public function find( $id );

    public function create( $data );

    public function update( $id, $data );

    public function delete( $id );

}
