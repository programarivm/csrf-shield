<?php
namespace CsrfShield\Exception;

use CsrfShield\Exception;

/**
 * Thrown when there is no csrf token in the session.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
final class EmptyCsrfTokenException extends \UnexpectedValueException implements Exception
{
    protected $message = 'The session does not contain a csrf token.';
}
