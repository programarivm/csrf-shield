<?php
namespace CsrfShield;

use CsrfShield\Singleton;
use CsrfShield\Exception\SessionException;

/**
 * Main class.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class CsrfShield extends Singleton
{
    public function init() {
        if (empty(session_id())) {
            throw new SessionException("The session is not been started.");
        }

        $_SESSION['csrf_shield_token'] = sha1(uniqid(mt_rand()));

        return $this;
    }

    public function getToken() {
        if (empty($_SESSION['csrf_shield_token'])) {
            throw new SessionException("The session does not contain a 'csrf_shield_token'.");
        }

        return $_SESSION['csrf_shield_token'];
    }

    public function validate($token) {
        if (empty($_SESSION['csrf_shield_token'])) {
            throw new SessionException("The session does not contain a 'csrf_shield_token'.");
        }

        return $token === $_SESSION['csrf_shield_token'];
    }

    public function getHtmlInput() {
        if (empty($_SESSION['csrf_shield_token'])) {
            throw new SessionException("The session does not contain a 'csrf_shield_token'.");
        }

        return '<input
            type="hidden"
            name="csrf_shield_token"
            id="csrf_shield_token"
            value="' . $_SESSION['csrf_shield_token'] . '" />';
    }
}
