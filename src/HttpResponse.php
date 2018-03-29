<?php
namespace CsrfShield;

use CsrfShield\CsrfSession;
use CsrfShield\Html;

/**
 * HTTP responses.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class HttpResponse
{
    /**
     * Sends an HTTP Forbidden response.
     */
    public static function forbidden()
    {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode([
            'message' => 'Forbidden.'
        ]);
        exit;
    }

    /**
     * Sends an HTTP Method Not Allowed response.
     */
    public static function methodNotAllowed()
    {
        http_response_code(405);
        header('Content-Type: application/json');
        echo json_encode([
            'message' => 'Method not allowed.'
        ]);
        exit;
    }
}
