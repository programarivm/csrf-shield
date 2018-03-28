<?php
namespace CsrfShield;

use CsrfShield\Exception\SessionException;
use CsrfShield\CsrfSession;

/**
 * Html class.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Html
{
    private $csrfSession;

    public function __construct($csrfSession = null)
    {
        if (empty(session_id())) {
            throw new SessionException("The session is not been started.");
        }

        if (empty($csrfSession->getToken())) {
            throw new SessionException("The session does not contain a '" . $csrfSession::NAME . "' value.");
        }

        $this->csrfSession = $csrfSession;
    }



    public function input()
    {
        if (empty(session_id())) {
            throw new SessionException("The session is not been started.");
        }

        if (empty($this->csrfSession->getToken())) {
            throw new SessionException("The session does not contain a '" . $this->csrfSession::NAME . "' value.");
        }

        return '<input type="hidden" name="' . $this->csrfSession::NAME . '" id="' . $this->csrfSession::NAME . '" value="' . $_SESSION[$this->csrfSession::NAME] . '" />';
    }
}
