<?php
namespace CsrfShield;

use CsrfShield\CsrfSession;
use CsrfShield\Exception\EmptyCsrfTokenException;
use CsrfShield\Exception\UnstartedSessionException;

/**
 * Protection class.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Protection
{
    private $csrfSession;

    public function __construct()
    {
        $this->csrfSession = new CsrfSession;

        $this->protect();
    }

    private function get()
    {
        // ...
    }

    private function post()
    {
        // ...
    }

    private function protect()
    {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->get();
                break;
            case 'POST':
                $this->post();
                break;
        }
    }
}
