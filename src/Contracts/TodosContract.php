<?php

namespace FourteenFour\Basecamp\Contracts;

interface TodosContract {

    public function all();

    public function page( $page );

    public function completed();

    public function archived();

    public function trashed();

    public function find( $id );

    public function create( $data );

    public function update( $id, $data );

    public function complete( $id );

    public function uncomplete( $id );

    public function reposition( $id, $position );

    public function trash( $id );

}
