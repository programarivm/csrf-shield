<?php
namespace CsrfShield;

use CsrfShield\Exception\SessionException;

/**
 * Main class.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
final class CsrfShield
{
    const NAME = 'csrf_shield_token';

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

    public function init() {
        $_SESSION[self::NAME] = sha1(uniqid(mt_rand()));

        return $this;
    }

    public function getToken() {
        if (empty($_SESSION[self::NAME])) {
            throw new SessionException("The session does not contain a '" . self::NAME . "' value.");
        }

        return $_SESSION['csrf_shield_token'];
    }

    public function validate($token) {
        if (empty($_SESSION[self::NAME])) {
            throw new SessionException("The session does not contain a '" . self::NAME . "' value.");
        }

        return $token === $_SESSION['csrf_shield_token'];
    }

    public function getHtmlInput() {
        if (empty($_SESSION[self::NAME])) {
            throw new SessionException("The session does not contain a '" . self::NAME . "' value.");
        }

        return '<input
            type="hidden"
            name="csrf_shield_token"
            id="csrf_shield_token"
            value="' . $_SESSION[self::NAME] . '" />';
    }
}
