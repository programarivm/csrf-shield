<?php
namespace CsrfShield\Tests\Unit;

use CsrfShield\CsrfSession;
use CsrfShield\Exception\SessionException;
use CsrfShield\Html;
use PHPUnit\Framework\TestCase;

class HtmlTest extends TestCase
{
    /**
     * @test
     */
    public function input()
    {
        session_start();
        $csrfSession = (new CsrfSession)->generate();
        $htmlInput = (new Html($csrfSession))->input();
        $token = $csrfSession->getToken();
        session_destroy();

        $this->assertEquals($htmlInput,
            '<input type="hidden" name="' . $csrfSession::NAME . '" id="' . $csrfSession::NAME . '" value="' . $token . '" />'
        );
    }

    /**
     * @test
     */
    public function input_without_csrf_token_in_session()
    {
        $caught = false;

        session_start();

        try {
            $csrfSession = new CsrfSession;
            $htmlInput = (new Html($csrfSession))->input();
        } catch (SessionException $e) {
            $caught = true;
            $this->assertTrue(true);
        } finally {
            session_destroy();
        }

        if (!$caught) {
            $this->assertTrue(false);
        }
    }
}
