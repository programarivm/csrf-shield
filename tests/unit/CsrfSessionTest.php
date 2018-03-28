<?php
namespace CsrfShield\Tests\Unit;

use CsrfShield\CsrfSession;
use CsrfShield\Exception\SessionException;
use PHPUnit\Framework\TestCase;

class CsrfSessionTest extends TestCase
{
    /**
     * @test
     */
    public function instantiate()
    {
        session_start();
        $csrfSession = new CsrfSession;
        session_destroy();

        $this->assertInstanceOf(CsrfSession::class, $csrfSession);
    }

    /**
     * @test
     */
    public function instantiate_without_session_started_already()
    {
        $this->expectException(SessionException::class);

        $csrfSession = new CsrfSession;
    }

    /**
     * @test
     */
    public function get_token()
    {
        session_start();
        $token = (new CsrfSession)->generate()->getToken();
        session_destroy();

        $this->assertTrue(is_string($token));
        $this->assertEquals(40, strlen($token));
    }

    /**
     * @test
     */
    public function get_token_no_chaining_methods()
    {
        session_start();
        $csrfSession = (new CsrfSession)->generate();
        $token = $csrfSession->getToken();
        session_destroy();

        $this->assertTrue(is_string($token));
        $this->assertEquals(40, strlen($token));
    }

    /**
     * @test
     */
    public function get_token_without_session_started_already()
    {
        $this->expectException(SessionException::class);

        $token = (new CsrfSession)->generate()->getToken();
    }

    /**
     * @test
     */
    public function get_token_without_csrf_token_in_session()
    {
        $caught = false;

        session_start();

        try {
            $token = (new CsrfSession)->getToken();
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

    /**
     * @test
     */
    public function is_valid()
    {
        session_start();
        $csrfSession = (new CsrfSession)->generate();
        $token = $csrfSession->getToken();
        $isValid = $csrfSession->validate($token);
        session_destroy();

        $this->assertTrue($isValid);
    }

    /**
     * @test
     */
    public function is_invalid()
    {
        session_start();
        $csrfSession = (new CsrfSession)->generate();
        $token = 'foo';
        $isValid = $csrfSession->validate($token);
        session_destroy();

        $this->assertFalse($isValid);
    }

    /**
     * @test
     */
    public function validate_without_csrf_token_in_session()
    {
        $caught = false;

        session_start();

        try {
            $isValid = (new CsrfSession)->validate('foo');
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