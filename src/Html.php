<?php
namespace CsrfShield;

use CsrfShield\CsrfSession;
use CsrfShield\Exception\EmptyCsrfTokenException;
use CsrfShield\Exception\UnstartedSessionException;

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
            throw new UnstartedSessionException();
        }

        if (empty($csrfSession->getToken())) {
            throw new EmptyCsrfTokenException();
        }

        $this->csrfSession = $csrfSession;
    }



    public function input()
    {
        if (empty(session_id())) {
            throw new UnstartedSessionException();
        }

        if (empty($this->csrfSession->getToken())) {
            throw new EmptyCsrfTokenException();
        }

        return '<input type="hidden" name="' . $this->csrfSession::NAME . '" id="' . $this->csrfSession::NAME . '" value="' . $_SESSION[$this->csrfSession::NAME] . '" />';
    }
}
