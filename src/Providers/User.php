<?php

namespace FourteenFour\Basecamp\Providers;

use GuzzleHttp\Client;
use Symfony\Component\CssSelector\Parser\Token;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;

class User extends AbstractApi {

    /**
     * Get All information about about current User
     *
     * @return Array Authoized users information
     */
    public function all() {

        return (array)$this->get("https://launchpad.37signals.com/authorization.json");

    }

    /**
     * Gets the Expiration time of the current Token
     *
     * @return String Date string of token expiration.
     */
    public function expires() {

        $response = (array)$this->get("https://launchpad.37signals.com/authorization.json");

        return $response['expires_at'];

    }

    /**
     * Get User Identity
     *
     * @return Object Identity of the user.
     */
    public function identity() {

        $response = (array)$this->get("https://launchpad.37signals.com/authorization.json");

        return $response['identity'];

    }

    /**
     * Get User Identity
     *
     * @return Object Identity of the user.
     */
    public function me() {

        $response = (array)$this->get("/my/profile.json");

        return $response;

    }

    /**
     * Get accounts of the current User
     *
     * @return Array Accounts that user is currently assigned to.
     */
    public function accounts( ) {

        $response = (array)$this->get("https://launchpad.37signals.com/authorization.json");

        return $response['accounts'];

    }

    /**
     * Get Users Comments
     *
     * @param Array $params Params to be passed to Basecamp
     * @return Array Users Comments
     */
    public function comments( $params = [] ) {

        $params['type'] = 'Comment';

        return $this->getAll( $params );

    }

    /**
     * Get Users Comments
     *
     * @param Array $params Params to be passed to Basecamp
     * @return Array Users Documents
     */
    public function documents( $params = [] ) {

        $params['type'] = 'Document';

        return $this->getAll( $params );

    }

    /**
     * Get Users Messages
     *
     * @param Array $params Params to be passed to Basecamp
     * @return Array Users Messages
     */
    public function messages( $params = [] ) {

        $params['type'] = 'Message';

        return $this->getAll( $params );

    }

    /**
     * Get User Questions and Answers
     *
     * @param Array $params Params to be passed to Basecamp
     * @return Array Users Messages
     */
    public function questions( $params = [] ) {

        $params['type'] = 'Question::Answer';

        return $this->getAll( $params );

    }

    /**
     * Get User Schedule Entries
     *
     * @param Array $params Params to be passed to Basecamp
     * @return Array Users Schedule Entries
     */
    public function schedules( $params = [] ) {

        $params['type'] = 'Schedule::Entry';

        return $this->getAll( $params );

    }

    /**
     * Get User ToDos
     *
     * @param Array $params Params to be passed to Basecamp
     * @return Array Users ToDos
     */
    public function todos( $params = [] ) {

        $params['type'] = 'Todo';

        return $this->getAll( $params );

    }

    /**
     * Get User ToDo Lists
     *
     * @param Array $params Params to be passed to Basecamp
     * @return Array Users ToDo Lists
     */
    public function todolists( $params = [] ) {

        $params['type'] = 'Todolist';

        return $this->getAll( $params );

    }

    /**
     * Get User Uploads
     *
     * @param Array $params Params to be passed to Basecamp
     * @return Array Users Uploads
     */
    public function uploads( $params = [] ) {

        $params['type'] = 'Upload';

        return $this->getAll( $params );

    }

    /**
     * Page through the results for a request
     *
     * @param Array $params Request Parameters
     * @return Array Merged ResponseListener from from Basecamp
     */
    private function getAll( $params = [] ) {

        $data = [];
        $page = 0;
        $total = 1;

        while ( count($data) < $total ) {

            $response = $this->page( $page, $params );

            $total = (int)$this->headers['X-Total-Count'][0];

            $data = array_merge($data, $response);

            $page++;

        }

        return $data;

    }

    /**
     * Request Page from Basecamp
     *
     * @param integer $page   Page to request
     * @param Array  $params Query Params
     * @return Array Response from Basecamp.
     */
    private function page( $page = 0, $params = [] ) {

        // TODO require accountid

        return $this->get( "/projects/recordings.json?page=$page", $params );

    }

}
