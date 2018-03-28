<?php
namespace CsrfShield;

use CsrfShield\Exception\SessionException;

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
            throw new SessionException("The session is not been started.");
        }
    }

    public function generate() {
        $_SESSION[self::NAME] = sha1(uniqid(mt_rand()));

        return $this;
    }

    public function getToken() {
        if (empty($_SESSION[self::NAME])) {
            throw new SessionException("The session does not contain a '" . self::NAME . "' value.");
        }

        return $_SESSION[self::NAME];
    }

    public function validate($token) {
        if (empty($_SESSION[self::NAME])) {
            throw new SessionException("The session does not contain a '" . self::NAME . "' value.");
        }

        return $token === $_SESSION[self::NAME];
    }
}
