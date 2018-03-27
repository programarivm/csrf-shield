<?php
namespace CsrfShield\Tests\Unit;

use CsrfShield\CsrfShield;
use CsrfShield\Exception\SessionException;
use PHPUnit\Framework\TestCase;

class CsrfShieldTest extends TestCase
{
    const NAME = 'csrf_shield_token';

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
        $token = CsrfShield::getInstance()->generate()->getToken();
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
        CsrfShield::getInstance()->generate();
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

        CsrfShield::getInstance()->generate()->getToken();
    }

    /**
     * @test
     */
    public function is_valid()
    {
        session_start();
        $token = CsrfShield::getInstance()->generate()->getToken();
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
        $isValid = CsrfShield::getInstance()->generate()->validate($token);
        session_destroy();

        $this->assertFalse($isValid);
    }

    /**
     * @test
     */
    public function get_html_input()
    {
        session_start();
        $token = CsrfShield::getInstance()->generate()->getToken();
        $htmlInput = CsrfShield::getInstance()->getHtmlInput();
        session_destroy();
        
        $this->assertEquals($htmlInput,
            '<input type="hidden" name="_' . self::NAME . '" id="_' . self::NAME . '" value="' . $token . '" />'
        );
    }
}
