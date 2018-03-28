<?php
namespace CsrfShield\Exception;

use CsrfShield\Exception;

/**
 * Thrown when there is an issue with the session.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
final class CsrfSessionException extends \UnexpectedValueException implements Exception
{

}
