<?php
namespace CsrfShield;

use CsrfShield\Exception\EmptyCsrfTokenException;
use CsrfShield\Exception\UnstartedSessionException;

/**
 * CsrfSession class.
 *
 * Handles the CSRF token in the PHP session.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class CsrfSession
{
    const NAME = '_csrf_shield_token';

    /**
     * Constructor.
     */
    public function __construct()
    {
        if (empty(session_id())) {
            throw new UnstartedSessionException();
        }
    }

    /**
     * Creates and stores a new CSRF token into the session.
     *
     * @return CsrfSession
     */
    public function startToken() {
        if (empty(session_id())) {
            throw new UnstartedSessionException();
        }

        $_SESSION[self::NAME] = sha1(uniqid(mt_rand()));

        return $this;
    }

    /**
     * Gets the current CSRF token from the session.
     *
     * @return string
     */
    public function getToken() {
        if (empty(session_id())) {
            throw new UnstartedSessionException();
        }

        if (empty($_SESSION[self::NAME])) {
            throw new EmptyCsrfTokenException();
        }

        return $_SESSION[self::NAME];
    }

    /**
     * Validates the incoming CSRF token against the session.
     *
     * @return boolean
     */
    public function validateToken($token) {
        if (empty(session_id())) {
            throw new UnstartedSessionException();
        }

        if (empty($_SESSION[self::NAME])) {
            throw new EmptyCsrfTokenException();
        }

        return $token === $_SESSION[self::NAME];
    }
}
