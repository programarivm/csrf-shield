<?php
namespace CsrfShield;

use CsrfShield\Exception\SessionException;

/**
 * CsrfShield class.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
final class CsrfShield
{
    const NAME = '_csrf_shield_token';

    protected static $instance;

    public static function getInstance()
    {
        if (empty(session_id())) {
            throw new SessionException("The session is not been started.");
        }

        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
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

    public function getHtmlInput() {
        if (empty($_SESSION[self::NAME])) {
            throw new SessionException("The session does not contain a '" . self::NAME . "' value.");
        }

        return '<input type="hidden" name="' . self::NAME . '" id="' . self::NAME . '" value="' . $_SESSION[self::NAME] . '" />';
    }
}
