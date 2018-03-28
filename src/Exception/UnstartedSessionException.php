<?php
namespace CsrfShield\Exception;

use CsrfShield\Exception;

/**
 * Thrown when the session is not been started.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
final class UnstartedSessionException extends \UnexpectedValueException implements Exception
{
    protected $message = 'The session is not been started.';
}
