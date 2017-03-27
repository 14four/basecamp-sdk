<?php

namespace FourteenFour\Basecamp\Contracts;

interface TodosContracts {

    public function all( $status );

    public function page( $page, $status );

    public function archived();

    public function trashed();

    public function find( $id );

    public function create( $data );

    public function update( $id, $data );

    public function trash( $id );

}
