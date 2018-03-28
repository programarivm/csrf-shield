<?php
namespace CsrfShield;

use CsrfShield\Exception\EmptyCsrfTokenException;
use CsrfShield\Exception\UnstartedSessionException;

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
            throw new UnstartedSessionException();
        }
    }

    public function generate() {
        if (empty(session_id())) {
            throw new UnstartedSessionException();
        }

        $_SESSION[self::NAME] = sha1(uniqid(mt_rand()));

        return $this;
    }

    public function getToken() {
        if (empty(session_id())) {
            throw new UnstartedSessionException();
        }

        if (empty($_SESSION[self::NAME])) {
            throw new EmptyCsrfTokenException();
        }

        return $_SESSION[self::NAME];
    }

    public function validate($token) {
        if (empty(session_id())) {
            throw new UnstartedSessionException();
        }

        if (empty($_SESSION[self::NAME])) {
            throw new EmptyCsrfTokenException();
        }

        return $token === $_SESSION[self::NAME];
    }
}
