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
        $_SESSION['csrf_shield_token'] = sha1(uniqid(mt_rand()));

        return $this;
    }

    public function getToken() {
        if (empty($_SESSION['csrf_shield_token'])) {
            throw new SessionException(
                "The session does not contain a 'csrf_shield_token'."
            );
        }

        return $_SESSION['csrf_shield_token'];
    }
}
