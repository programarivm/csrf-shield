<?php
namespace CsrfShield;

use CsrfShield\Singleton;

/**
 * Main class.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class CsrfShield extends Singleton
{
    private $token;

    public function init() {
        $this->token = sha1(uniqid(mt_rand()));

        if (empty(session_id())) {
            session_start();
        }

        $_SESSION['csrf_shield'] = $this->token;

        return $this;
    }

    public function getToken() {
        return $this->token;
    }
}
