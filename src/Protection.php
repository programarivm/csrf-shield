<?php
namespace CsrfShield;

use CsrfShield\CsrfSession;
use CsrfShield\Html;

/**
 * Protection class.
 *
 * This is the main class which basically acts as a wrapper of CsrfShield\CsrfSession
 * and CsrfShield\Html.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Protection
{
    /**
     * The CSRF session.
     *
     * @var CsrfSession
     */
    private $csrfSession;

    /**
     * HTML renderer.
     *
     * @var Html
     */
    private $html;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->csrfSession = new CsrfSession;
        $this->html = new Html($this->csrfSession);
    }

    /**
     * Creates and stores a new CSRF token into the session.
     */
    public function startToken()
    {
        $this->csrfSession->startToken();
    }

    /**
     * Gets the current CSRF token from the session.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->csrfSession->getToken();
    }

    /**
     * Returns an HTML input tag with the value of the current CSRF token embedded.
     *
     * @return string
     */
    public function htmlInput()
    {
        return $this->html->input();
    }

    /**
     * Validates the incoming CSRF token against the session's token.
     */
    public function validateToken()
    {
        switch (true) {

            case $_SERVER['REQUEST_METHOD'] !== 'POST':
                $this->methodNotAllowed();
                break;

            case !empty($_SERVER['HTTP_X_CSRF_TOKEN']):
                if (!$this->csrfSession->validateToken($_SERVER['HTTP_X_CSRF_TOKEN'])) {
                    $this->forbidden();
                }
                break;

            default:
                if (!$this->csrfSession->validateToken($_POST[$this->csrfSession::NAME])) {
                    $this->forbidden();
                }
                break;
        }
    }

    /**
     * Sends an HTTP Forbidden response.
     */
    private function forbidden()
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
    private function methodNotAllowed()
    {
        http_response_code(405);
        header('Content-Type: application/json');
        echo json_encode([
            'message' => 'Method not allowed.'
        ]);
        exit;
    }
}
