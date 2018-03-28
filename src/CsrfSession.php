<?php
namespace CsrfShield;

use CsrfShield\Exception\CsrfSessionException;

/**
 * Session class.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class CsrfSession
{
    const NAME = '_csrf_shield_token';

    public function __construct()
    {
        if (empty(session_id())) {
            throw new CsrfSessionException("The session is not been started.");
        }
    }

    public function generate() {
        if (empty(session_id())) {
            throw new CsrfSessionException("The session is not been started.");
        }

        $_SESSION[self::NAME] = sha1(uniqid(mt_rand()));

        return $this;
    }

    public function getToken() {
        if (empty(session_id())) {
            throw new CsrfSessionException("The session is not been started.");
        }

        if (empty($_SESSION[self::NAME])) {
            throw new CsrfSessionException("The session does not contain a '" . self::NAME . "' value.");
        }

        return $_SESSION[self::NAME];
    }

    public function validate($token) {
        if (empty(session_id())) {
            throw new CsrfSessionException("The session is not been started.");
        }
        
        if (empty($_SESSION[self::NAME])) {
            throw new CsrfSessionException("The session does not contain a '" . self::NAME . "' value.");
        }

        return $token === $_SESSION[self::NAME];
    }
}
