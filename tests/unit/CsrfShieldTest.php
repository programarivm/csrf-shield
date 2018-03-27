<?php
namespace CsrfShield\Tests\Unit;

use CsrfShield\CsrfShield;
use CsrfShield\Exception\SessionException;
use PHPUnit\Framework\TestCase;

class CsrfShieldTest extends TestCase
{
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
    public function get_instance()
    {
        session_start();
        $csrfShield = CsrfShield::getInstance();
        session_destroy();

        $this->assertInstanceOf(CsrfShield::class, $csrfShield);
    }

    /**
     * @test
     */
    public function get_instance_without_session_started_already()
    {
        $this->expectException(SessionException::class);

        $csrfShield = CsrfShield::getInstance();
    }

    /**
     * @test
     */
    public function get_token()
    {
        session_start();
        $token = CsrfShield::getInstance()->init()->getToken();
        session_destroy();

        $this->assertTrue(is_string($token));
        $this->assertEquals(40, strlen($token));
    }

    /**
     * @test
     */
    public function get_token_without_chaining_methods()
    {
        session_start();
        CsrfShield::getInstance()->init();
        $token = CsrfShield::getInstance()->getToken();
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

        CsrfShield::getInstance()->init()->getToken();
    }

    /**
     * @test
     */
    public function is_valid()
    {
        session_start();
        $token = CsrfShield::getInstance()->init()->getToken();
        $isValid = CsrfShield::getInstance()->validate($token);
        session_destroy();

        $this->assertTrue($isValid);
    }

    /**
     * @test
     */
    public function is_invalid()
    {
        session_start();
        $token = 'foo';
        $isValid = CsrfShield::getInstance()->init()->validate($token);
        session_destroy();

        $this->assertFalse($isValid);
    }

    /**
     * @test
     */
    public function get_html_input()
    {
        session_start();
        $token = CsrfShield::getInstance()->init()->getToken();
        $htmlInput = CsrfShield::getInstance()->getHtmlInput();
        session_destroy();

        $this->assertEquals($htmlInput, '<input
            type="hidden"
            name="csrf_shield_token"
            id="csrf_shield_token"
            value="' . $token . '" />'
        );
    }
}
