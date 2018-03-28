<?php
namespace CsrfShield\Tests\Unit;

use CsrfShield\CsrfShield;
use CsrfShield\Exception\SessionException;
use PHPUnit\Framework\TestCase;

class CsrfShieldTest extends TestCase
{
    const NAME = '_csrf_shield_token';

    public function setUp()
    {
        // ...
    }

    public function tearDown()
    {
        // ...
    }

    /**
     * @test
     */
    public function instantiate()
    {
        session_start();
        $csrfShield = new CsrfShield;
        session_destroy();

        $this->assertInstanceOf(CsrfShield::class, $csrfShield);
    }

    /**
     * @test
     */
    public function instantiate_without_session_started_already()
    {
        $this->expectException(SessionException::class);

        $csrfShield = new CsrfShield;
    }

    /**
     * @test
     */
    public function get_token()
    {
        session_start();
        $token = (new CsrfShield)->generate()->getToken();
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
        $csrfShield = (new CsrfShield)->generate();
        $token = $csrfShield->getToken();
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

        $token = (new CsrfShield)->generate()->getToken();
    }

    /**
     * @test
     */
    public function get_token_without_csrf_token_in_session()
    {
        $caught = false;

        session_start();

        try {
            $token = (new CsrfShield)->getToken();
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
        $csrfShield = (new CsrfShield)->generate();
        $token = $csrfShield->getToken();
        $isValid = $csrfShield->validate($token);
        session_destroy();

        $this->assertTrue($isValid);
    }

    /**
     * @test
     */
    public function is_invalid()
    {
        session_start();
        $csrfShield = (new CsrfShield)->generate();
        $token = 'foo';
        $isValid = $csrfShield->validate($token);
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
            $isValid = (new CsrfShield)->validate('foo');
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
    public function get_html_input()
    {
        session_start();
        $csrfShield = (new CsrfShield)->generate();
        $token = $csrfShield->getToken();
        $htmlInput = $csrfShield->getHtmlInput();
        session_destroy();

        $this->assertEquals($htmlInput,
            '<input type="hidden" name="' . self::NAME . '" id="' . self::NAME . '" value="' . $token . '" />'
        );
    }

    /**
     * @test
     */
    public function get_html_input_without_csrf_token_in_session()
    {
        $caught = false;

        session_start();

        try {
            $htmlInput = (new CsrfShield)->getHtmlInput();
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
