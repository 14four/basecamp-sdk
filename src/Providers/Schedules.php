<?php

namespace FourteenFour\Basecamp\Providers;

class Schedules extends AbstractApi {

    public function setBasecamp( $basecampId ) {

        $this->otpions['basecamp'] = $basecampId;

        return $this;

    }

    public function getBasecamp() {

        return $this->otpions['basecamp'];

    }

    public function find() {

    }

}
