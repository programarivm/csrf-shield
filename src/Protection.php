<?php
namespace CsrfShield;

use CsrfShield\CsrfSession;
use CsrfShield\Exception\EmptyCsrfTokenException;
use CsrfShield\Exception\UnstartedSessionException;
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
     */
    public function getToken()
    {
        $this->csrfSession->getToken();
    }

    /**
     * Returns an HTML input tag with the value of the current CSRF token embedded.
     */
    public function htmlInput()
    {
        return $this->html->input();
    }

    /**
     * Validates the incoming CSRF token against the session's token, assuming
     * the token is sent through the $_POST['_csrf_shield_token'] value.
     */
    public function validateToken()
    {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                if (!$this->csrfSession->validateToken($_POST[$this->csrfSession::NAME])) {
                    http_response_code(403);
                    header('Content-Type: application/json');
                    echo json_encode([
                        'message' => 'Whoops! You are not authorized to access this resource.']
                    );
                    exit;
                }

                break;
        }
    }
}
