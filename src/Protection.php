<?php
namespace CsrfShield;

use CsrfShield\CsrfSession;
use CsrfShield\Exception\EmptyCsrfTokenException;
use CsrfShield\Exception\UnstartedSessionException;
use CsrfShield\Html;

/**
 * Protection class.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Protection
{
    private $csrfSession;

    private $html;

    public function __construct()
    {
        $this->csrfSession = new CsrfSession;

        $this->html = new Html($this->csrfSession);

        $this->protect();
    }

    public function getCsrfSession()
    {
        return $this->csrfSession;
    }

    public function getHtml()
    {
        return $this->html;
    }

    private function protect()
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
