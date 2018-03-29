<?php
namespace CsrfShield;

use CsrfShield\CsrfSession;
use CsrfShield\Html;
use CsrfShield\HttpResponse;

/**
 * Protection class.
 *
 * Acts as a wrapper of CsrfShield\CsrfSession and CsrfShield\Html.
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
                HttpResponse::methodNotAllowed();
                break;

            case isset($_SERVER['HTTP_X_CSRF_TOKEN']):
                if (!$this->csrfSession->validateToken($_SERVER['HTTP_X_CSRF_TOKEN'])) {
                    HttpResponse::forbidden();
                }
                break;

            default:
                if (!$this->csrfSession->validateToken($_POST[$this->csrfSession::NAME])) {
                    HttpResponse::forbidden();
                }
                break;
        }
    }
}
